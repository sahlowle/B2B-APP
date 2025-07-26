<?php

namespace App\Lib\Themeable;

use Illuminate\Support\Collection;

class ThemeInfo
{
    public $theme;

    public function __construct(Collection $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the theme's thumbnail URL.
     */
    public function thumbnailUrl(): string
    {
        if (file_exists($this->theme->get('thumbnail'))) {
            return url($this->theme->get('thumbnail'));
        }

        return url(defaultImage('theme'));
    }

    /**
     * Handle dynamic method calls to the object.
     *
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call(string $method, array $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method(...$parameters);
        }

        if ($this->theme->has($method)) {
            return $this->theme->get($method);
        }
    }
}
