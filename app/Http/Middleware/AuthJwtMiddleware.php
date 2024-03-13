<?php

namespace App\Http\Middleware;

use App\Models\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie("x-token")) {
            // throw new HttpException(401, "UNATHORIZED");
            return redirect("/web/signIn");
        }
        $token = $request->cookie("x-token");
        if (!$token) {
            // throw new HttpException(401, "UNATHORIZED");
            return redirect("/web/signIn");
        }

        Auth::guard("jwt")->setToken($token);
        $userId = Auth::guard("jwt")->user()->getAuthIdentifier();
        if (!$userId) {
            throw new HttpException(403, "FORBIDDEN");
        }
        $user = User::where("id", $userId)->first();
        if (!$user) {
            throw new HttpException(403, "FORBIDDEN");
        }
        // if ($user->role != UserRole::ADMIN->value) {
        //     throw new HttpException(403, "FORBIDDEN");
        // }
        $request->attributes->add(["me" => $user]);
        return $next($request);
    }
}
