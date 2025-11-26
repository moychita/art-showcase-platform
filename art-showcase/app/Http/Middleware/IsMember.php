<?php
// app/Http/Middleware/IsMember.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsMember
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isMember()) {
            abort(403, 'Member access required.');
        }
        return $next($request);
    }
}