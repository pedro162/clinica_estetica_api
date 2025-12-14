<?php

namespace App\Http\Middleware\Metrics;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Prometheus\CollectorRegistry;

use function Ramsey\Uuid\v1;

class PrometheusMetrics
{
    public function __construct(private CollectorRegistry $registry) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->path() === 'metrics') {
            return $next($request);
        }

        $start = microtime(true);

        $response = $next($request);
        $route = optional($request->route())->getName() ?? $request->path();

        $histogram = $this->registry->getOrRegisterHistogram(
            'laravel',
            'http_request_duration_seconds',
            'Request duration in seconds',
            ['method', 'path', 'status'],
            [0.1, 0.3, 1, 3, 5]
        );

        $duration = microtime(true) - $start;
        $histogram->observe($duration, [
            $request->method(),
            $route,
            $response->getStatusCode(),
        ]);

        //---------
        $counter = $this->registry->getOrRegisterCounter(
            'laravel',
            'http_requests_total',
            'Total HTTP requests',
            ['method', 'path', 'status']
        );
        $counter->inc([
            $request->method(),
            $request->path(),
            $response->getStatusCode()
        ]);

        //---

        $error_counter = $this->registry->getOrRegisterCounter(
            'laravel',
            'http_errors_total',
            'Total HTTP errors',
            ['method', 'path', 'status']
        );

        if ($response->getStatusCode() >= 400) {
            $error_counter->inc([$request->method(), $request->path(), $response->getStatusCode()]);
        }

        //---
        $gauge = $this->registry->getOrRegisterGauge(
            'laravel',
            'boot_timestamp',
            'Laravel boot timestamp'
        );
        $gauge->set(time());

        return $response;
    }
}
