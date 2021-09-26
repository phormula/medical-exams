<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StructureOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \Structure $structure
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Gate::allows('manage-structure', $request->structure)){
            return $next($request);
        }

        return response()->json(['error' => 'You are not authorized to manage this resource.'],403);
    }
}
