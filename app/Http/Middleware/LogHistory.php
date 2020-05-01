<?php

namespace App\Http\Middleware;

use App\History;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LogHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $history = new History();
            $history->url = $request->url();
            $history->user = Auth::id();
            $history->save();
        }
        return $next($request);
    }
}
