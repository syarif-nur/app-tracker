<?php

namespace App\Traits;

trait HasMenus
{
    /**
     * Get menus available for current user with normalized permission flags on top-level.
     * Always includes: can_view, can_create, can_edit, can_delete as booleans.
     */
    public function getMenus()
    {
        $user = \Auth::user();
        $result = [];
        if ($user && $user->role) {
            if (!empty($user->role->is_super_user)) {
                // Super user: all menus with all permissions = true
                $result = \App\Models\Menu::orderBy('order')->get()->map(function ($menu) {
                    $arr = $menu->toArray();
                    $arr['can_view'] = true;
                    $arr['can_create'] = true;
                    $arr['can_edit'] = true;
                    $arr['can_delete'] = true;
                    return $arr;
                })->toArray();
            } else {
                // Fetch menus with pivot permissions and normalize to top-level keys
                $result = $user->role->menus()
                    ->orderBy('menus.order')
                    ->get()
                    ->map(function ($menu) {
                        $arr = $menu->toArray();
                        $arr['can_view'] = (bool)($menu->pivot->can_view ?? false);
                        $arr['can_create'] = (bool)($menu->pivot->can_create ?? false);
                        $arr['can_edit'] = (bool)($menu->pivot->can_edit ?? false);
                        $arr['can_delete'] = (bool)($menu->pivot->can_delete ?? false);
                        // Optional: you can unset pivot to keep payload clean
                        unset($arr['pivot']);
                        return $arr;
                    })
                    // Optionally only show menus the user can view in navigation
                    ->filter(function ($m) { return !empty($m['can_view']); })
                    ->values()
                    ->toArray();
            }
        }
        return $result;
    }

    /**
     * Return permission flags for a given route name or path.
     * Accepts route name like 'users' or path like '/users'.
     */
    public function getMenuPermissionsByRoute(string $route)
    {
        $normalized = ltrim($route, '/');
        $user = \Auth::user();
        $perms = [
            'can_view' => false,
            'can_create' => false,
            'can_edit' => false,
            'can_delete' => false,
        ];
        if ($user && $user->role) {
            if (!empty($user->role->is_super_user)) {
                return array_map(fn() => true, $perms);
            }
            $menu = $user->role->menus()->where(function ($q) use ($normalized) {
                $q->where('route', $normalized)->orWhere('route', '/' . $normalized);
            })->first();
            if ($menu) {
                $perms['can_view'] = (bool)($menu->pivot->can_view ?? false);
                $perms['can_create'] = (bool)($menu->pivot->can_create ?? false);
                $perms['can_edit'] = (bool)($menu->pivot->can_edit ?? false);
                $perms['can_delete'] = (bool)($menu->pivot->can_delete ?? false);
            }
        }
        return $perms;
    }

    /**
     * Quick check for a specific permission on a route.
     */
    public function canOnRoute(string $route, string $permission): bool
    {
        $perms = $this->getMenuPermissionsByRoute($route);
        return (bool)($perms[$permission] ?? false);
    }
}
