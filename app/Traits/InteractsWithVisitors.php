<?php

namespace App\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Models\Visitor;

/**
 * @method static Visitor visitors()
 * @method Visitor visitors()
 */
trait InteractsWithVisitors
{
    /**
     * Handle dynamic static method calls into the model.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if ($method == 'visitors') {
            return (new static)->createVisitor();
        }

        return (new static)->$method(...$parameters);
    }

    /**
     * Create Visitors Query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function createVisitor()
    {
        $baseQuery = Visitor::visitable(static::class);
        if (isset($this->id)) {
            $baseQuery = $baseQuery->visitableId($this->id);
        }

        return $baseQuery;
    }

    /**
     * Visit Model
     */
    public function visit(?Authenticatable $user = null, ?Request $request = null)
    {
        $user = $user ?? resolve(Authenticatable::class);
        $request = $request ?? resolve(Request::class);

         // Option 1: Update based on visitable, visitable_id, auth_id, and IP
        Visitor::updateOrCreate([
            'visitable' => static::class,
            'visitable_id' => $this->id,
            // 'auth_id' => $user?->id,
            'ip' => $request->ip(),
        ], [
            'auth_id' => $user?->id,
            'referer' => $request->header('referer'),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'updated_at' => now(), // Ensure updated_at is refreshed
        ]);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($method == 'visitors') {
            return $this->createVisitor();
        }

        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        if ($resolver = (static::$relationResolvers[get_class($this)][$method] ?? null)) {
            return $resolver($this);
        }

        return $this->forwardCallTo($this->newQuery(), $method, $parameters);
    }
}
