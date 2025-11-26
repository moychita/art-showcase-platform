<?php
// app/Http/Middleware/IsCurator.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsCurator
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if (!$user || !$user->isCurator()) {
            abort(403, 'Curator access required.');
        }
        
        if ($user->isPendingCurator()) {
            return redirect()->route('curator.pending');
        }
        
        return $next($request);
    }
}