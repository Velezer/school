<?php

namespace App\Http\Middleware;

use App\Models\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $me = $request->attributes->get("me");
        if ($me->role != UserRole::ADMIN->value) {
            throw new HttpException(403, "FORBIDDEN");
        }
        return $next($request);
    }
}
