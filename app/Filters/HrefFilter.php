<?php

namespace App\Filters;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use Illuminate\Contracts\Routing\UrlGenerator;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class HrefFilter implements FilterInterface
{
    protected $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function transform($item, Builder $builder)
    {
        if (! isset($item['header'])) {
            $item['href'] = $this->makeHref($item);
        }

        if (isset($item['submenu'])) {
            $item['submenu'] = array_map(function ($subitem) use ($builder) {
                return $this->transform($subitem, $builder);
            }, $item['submenu']);
        }

        return $item;
    }

    protected function makeHref($item)
    {
        if (isset($item['url'])) {
            return $this->urlGenerator->to($item['url']);
        }

        $user = Auth::user();
        $prefix = '';
        $route = '';

        if (!is_null($user)) {
            if ($user->isAdmin()) {
                $prefix = 'admin.';
            } else {
                $prefix = 'user.';
            }
        }

        if (isset($item['route'])) {
            if (is_array($item['route'])) {
                $route = $prefix . $item['route'][0];
                if (Route::has($route)) {
                    return $this->urlGenerator->route($route, $item['route'][1]);
                }
            }

            $route = $prefix . $item['route'];
            if (Route::has($route)) {
                return $this->urlGenerator->route($route);
            }
        }

        return '#';
    }
}
