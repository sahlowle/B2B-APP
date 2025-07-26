<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 27-12-2021
 */

namespace Modules\CMS\Http\Controllers;

use App\Constants\Product as ConstantsProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\AjaxSelectSearchResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\CMS\Entities\Component;
use Modules\CMS\Entities\ComponentProperty;
use Modules\CMS\Entities\Layout;
use Modules\CMS\Entities\LayoutType;
use Modules\CMS\Entities\Page;
use Modules\CMS\Service\AjaxResourceService;

class BuilderController extends Controller
{
    /**
     * Fields to ignore when inserting component properties
     */
    private $ignoreableFields = ['component', 'level', '_token', 'layout', 'section_name', 'file_id', 'file_id[]'];

    /**
     * Get component edit form
     *
     * @return mixed
     */
    public function editElement(Request $request)
    {
        if (! isset($request['file'])) {
            return false;
        }

        $layout = Layout::with('layoutType')->firstWhere('file', $request->file);

        if (! $layout) {
            return false;
        }

        $editorClosed = false;

        $level = uniqid('level_');

        return response(['body' => [
            'html' => view('cms::edit.' . $request->file, compact('layout', 'editorClosed', 'level'))->render(),
            'header' => view('cms::pieces.header-badges', ['layout' => $layout])->render(),
            'title' => $layout->name,
            'level' => $level,
        ]], 200);
    }

    /**
     * Edit Page
     *
     * @param  string  $slug
     * @return Renderable
     */
    public function edit($slug)
    {
        if (! request()->has('lang')) {
            return redirect()->route('builder.edit', ['slug' => $slug, 'lang' => 'en']);
        }

        $page = Page::with(['components' => function ($q) {
            $q->orderBy('level')->with(['properties', 'layout' => function ($q) {
                $q->with('layoutType:id,name');
            }]);
        }])->slug($slug)->first();

        if (! $page) {
            Session::flash('fail', __('Page not found.'));

            return redirect()->route('page.home');
        }
        $layouts = LayoutType::with(['layouts'])->orderBy('name')->get();
        $selector = view('cms::edit.selector', compact('layouts'));
        $queryOperations = ConstantsProduct::queryArray();

        return view('cms::builder', compact('layouts', 'page', 'selector', 'queryOperations'));
    }

    /**
     * Update component settings
     *
     * @return response()
     */
    public function updateComponent(Request $request)
    {
        $data = [];
        if ($request->data) {
            parse_str($request->data, $data);
        }

        array_walk_recursive($data, function (&$value) {
            $value = xss_clean(($value));
        });

        $request->request->add($data);

        $component = $this->getComponent($request, true);

        $this->saveProperties($component->id, $data, $request->input('lang', 'en'));

        return response(['body' => $component->id], 200);
    }

    /**
     * Delete a component
     *
     * @return bool
     */
    public function deleteComponent(Request $request)
    {
        $p = ComponentProperty::where('component_id', $request->data)->delete();
        $c = Component::where('id', $request->data)->delete();

        return response()->json(['body' => $p && $c]);
    }

    /**
     * Update All Components
     *
     * @return bool
     */
    public function updateAllComponents(Request $request)
    {
        if (! $request->data) {
            return false;
        }

        parse_str($request->data, $data);

        if (! is_array($data) || ! isset($data['component']) || ! is_array($data['component'])) {
            return false;
        }

        $components = $data['component'];

        foreach ($components as $component) {

            parse_str($component, $componentValue);

            array_walk_recursive($componentValue, function (&$value) {
                $value = xss_clean(($value));
            });

            $request->request->add($componentValue);

            $component = $this->getComponent($request);

            $array[] = $component->toArray();

            $this->saveProperties($component->id, $componentValue, $request->input('lang', 'en'));
        }

        return true;
    }

    /**
     * Process input value
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function processValue($value)
    {
        if (is_array($value)) {
            return [gettype($value), json_encode($value)];
        }

        return [gettype($value), $value];
    }

    /**
     * Provide component
     *
     * @param  mixed  $request
     * @param  bool  $reorder  Default = false
     * @return Component
     */
    private function getComponent($request, $reorder = false)
    {
        if ($request->component) {
            $component = Component::findOrFail($request->component);
            if (($reorder && $component->level != $request->level) || (! $reorder && $request->level)) {
                if ($reorder) {
                    $component->componentReorder($component->page_id, $component->level, $request->level);
                }
                $component->level = $request->level;
                $component->save();
            }
        } else {
            if ($reorder) {
                Component::componentReorder($request->id, 0, $request->level);
            }
            $component = Component::create([
                'page_id' => $request->id,
                'layout_id' => $request->layout,
                'level' => $request->level,
            ]);
        }

        return $component;
    }

    /**
     * Save properties for component
     *
     * @param  int  $component
     * @param array
     */
    private function saveProperties($component, $data, $language = 'en'): void
    {
        foreach ($data as $key => $value) {
            if (! in_array($key, $this->ignoreableFields)) {
                $value = $this->processValue($value);

                // Create or update with save method
                $componentProperty = ComponentProperty::where('component_id', $component)->where('name', $key)->first();

                if ($componentProperty) {
                    $componentProperty->setTranslated('value', $language, $value[1]);
                    $componentProperty->type = $value[0];
                    $componentProperty->save();
                } else {
                    ComponentProperty::create(['name' => $key, 'component_id' => $component, 'type' => $value[0], 'value' =>  [$language => $value[1]]]);
                }
            }
        }
    }

    /**
     * Provide ajax data search resources
     * this one is mainly designed for Select2 ajax data load
     * request string query parameters
     * column:string => Which model is needed
     * q:string => query search string
     *
     *
     * @return AjaxSelectSearchResource
     */
    public function ajaxResourceFetch(Request $request)
    {
        if (! $request->column) {
            return response()->json([]);
        }

        $data = (new AjaxResourceService($request))->get();

        if (! $data) {
            return response()->json(['data' => []]);
        }

        return AjaxSelectSearchResource::collection($data);
    }
}
