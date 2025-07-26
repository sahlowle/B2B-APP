<?php

namespace App\Lib\Themeable;

use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\View\ViewFinderInterface;

class Theme implements ThemeContract
{
    /**
     * Collection of all theme information.
     *
     * @var array
     */
    protected $themes = [];

    /**
     * Blade View Finder instance.
     *
     * @var \Illuminate\View\ViewFinderInterface
     */
    protected $finder;

    /**
     * Application container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Current active theme.
     *
     * @var string|null
     */
    private $activeTheme = null;

    /**
     * Theme constructor.
     */
    public function __construct(Container $app, ViewFinderInterface $finder, Repository $config)
    {
        $this->app = $app;
        $this->finder = $finder;
        $this->config = $config;
        if (config('martvill.app_install')) {
            $this->config->set('theme.active', preference('active_theme'));
            $this->activeTheme = $this->config->get('theme.active');
        }
    }

    /**
     * Add a new theme.
     */
    public function add(string $theme, array $themeInfo = []): void
    {
        $this->themes[$theme] = $themeInfo;
    }

    /**
     * Set the current theme.
     *
     *
     * @throws \InvalidArgumentException
     */
    public function set(string $theme): void
    {
        if (! $this->has($theme)) {
            return;
        }

        $this->loadTheme($theme);
        $this->activeTheme = $theme;
    }

    /**
     * Check if a theme exists.
     */
    public function has(string $theme): bool
    {
        return array_key_exists($theme, $this->themes);
    }

    /**
     * Get information about a particular theme.
     *
     *
     * @return ThemeInfo
     */
    public function getThemeInfo(string $themeName)
    {
        return new ThemeInfo(isset($this->themes[$themeName]) ? collect($this->themes[$themeName])->prepend($themeName, 'name') : collect());
    }

    /**
     * Get the current theme or information about a specific theme.
     */
    public function get(?string $theme = null): ThemeInfo
    {
        return is_null($theme) ? $this->getThemeInfo($this->activeTheme) : $this->getThemeInfo($theme);
    }

    /**
     * Get information about the current active theme.
     */
    public function current(): ThemeInfo
    {
        return $this->getThemeInfo($this->activeTheme);
    }

    /**
     * Get information about all themes.
     */
    public function all(): Collection
    {
        return collect($this->themes)->map(function ($theme, $name) {
            return $this->getThemeInfo($name);
        })->sortByDesc(function ($theme, $name) {
            return $name === 'default';
        })->values();
    }

    /**
     * Load the specified theme by mapping its view path.
     */
    private function loadTheme(string $theme): void
    {
        if (! $this->has($theme)) {
            return;
        }

        $themeInfo = $this->getThemeInfo($theme);

        if (! $themeInfo->theme->has('view_path')) {
            return;
        }

        $viewPath = $themeInfo->theme->get('view_path');
        $this->finder->prependLocation($viewPath);
        $this->finder->prependNamespace($themeInfo->theme->get('name'), $viewPath);
    }
}
