<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPropertyLimitMiddleware
{
    /**
     * Middleware to check if the user can create a property.
     *
     * This middleware ensures that:
     * - Admins always have access.
     * - The user has an active subscription.
     * - The user has not exceeded their property listing limit.
     *
     * If any of these conditions fail, an appropriate JSON response is returned.
     *
     * @param  Request  $request  The incoming request instance.
     * @param  Closure  $next  The next request handler.
     * @return Response The response instance.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->userSubscription?->active()) {
            return response()->json(['message' => 'You need an active subscription'], 403);
        }

        $currentPosts = $user->properties()->count();
        $postLimit = $user->userSubscription->plan->number_of_listings ?? 0;

        if ($currentPosts >= $postLimit) {
            return response()->json(['message' => 'Post limit exceeded, upgrade your plan'], 403);
        }

        return $next($request);
    }
}
