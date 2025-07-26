<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 27-02-2024
 */

namespace App\Http\Controllers;

use App\DataTables\CustomFIeldDataTable;
use App\Http\Requests\Admin\StoreCustomFieldRequest;
use App\Http\Requests\Admin\UpdateCustomFieldRequest;
use App\Models\CustomField;
use App\Services\CustomFieldService;
use Illuminate\Support\Facades\DB;

class CustomFieldController extends Controller
{
    /**
     * Custom Fields
     *
     * @return mixed
     */
    public function index(CustomFIeldDataTable $dataTable)
    {
        $data['fieldBelongs'] = CustomFieldService::fieldBelongsTo();
        $data['inputTypes'] = CustomFieldService::inputTypes();

        return $dataTable->render('admin.custom_fields.index', $data);
    }

    /**
     * Custom Field create
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['fieldBelongs'] = CustomFieldService::fieldBelongsTo();
        $data['inputTypes'] = CustomFieldService::inputTypes();

        return view('admin.custom_fields.create', $data);
    }

    /**
     * Custom Field store
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCustomFieldRequest $request, CustomFieldService $service)
    {
        DB::beginTransaction();

        try {
            $id = $service->storeField($request->validated());

            $service->storeFieldMeta($request->meta, $id);

            DB::commit();

            return to_route('custom_fields.index')
                ->withSuccess(__('The :x has been successfully saved.', ['x' => __('Custom Field')]));
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(__('Failed to save :x. ', ['x' => __('Custom Field')]) . $e->getMessage());
        }
    }

    /**
     * Custom Field edit
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $data['customField'] = CustomField::with('meta')->find($id);

        if (! $data['customField']) {
            return to_route('custom_fields.index')->withErrors(__('Custom Field not found.'));
        }

        $data['fieldBelongs'] = CustomFieldService::fieldBelongsTo();
        $data['inputTypes'] = CustomFieldService::inputTypes();

        return view('admin.custom_fields.edit', $data);
    }

    /**
     * Custom Field update
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCustomFieldRequest $request, CustomFieldService $service, $id)
    {
        DB::beginTransaction();

        try {
            $service->updateField($request->validated(), $id);

            $service->storeFieldMeta($request->meta, $id);

            DB::commit();

            return back()->withSuccess(__('The :x has been successfully saved.', ['x' => __('Custom Field')]));
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(__('Failed to save :x. ', ['x' => __('Custom Field')]) . $e->getMessage());
        }
    }

    /**
     * Delete Custom Field
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            CustomField::where('id', $id)->delete();

            return back()->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Custom Field')]));
        } catch (\Exception $e) {
            return back()->withErrors(__('Failed to delete :x. ', ['x' => __('Custom Field')]) . $e->getMessage());
        }
    }
}
