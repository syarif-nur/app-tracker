<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $permission
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = $request->user();
        $routeName = $request->route() ? $request->route()->getName() : null;
        if (!$user || !$user->role || !$routeName) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Cari menu berdasarkan route name
        $menu = $user->role->menus()->where('route', '/' . $routeName)->first();
        if (!$menu || !$menu->pivot->$permission) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
