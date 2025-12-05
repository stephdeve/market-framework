<?php
namespace Framework\Middleware;

use Framework\Core\Request;

interface Middleware {
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, callable $next);
}
