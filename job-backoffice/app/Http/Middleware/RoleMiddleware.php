<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Illuminate\Support\Facades\Auth;

    class RoleMiddleware
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
         */
        public function handle(Request $request, Closure $next, ...$roles): Response
        {
            // Check if the user is authenticated and has the required role
            if (Auth::check()) {
                $role = Auth::user()->role;
                $hasAccess = in_array($role, $roles);

                if (! $hasAccess) {
                    abort(403);
                }
            }
            //Has access
            return $next($request);
        }
    }
