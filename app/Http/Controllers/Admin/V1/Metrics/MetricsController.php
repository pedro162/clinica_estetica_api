<?php

namespace App\Http\Controllers\Admin\V1\Metrics;

use App\Http\Controllers\Controller;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    public function __construct(private CollectorRegistry $registry) {}

    public function index()
    {
        $renderer = new RenderTextFormat();
        $metrics = $this->registry->getMetricFamilySamples();

        return response($renderer->render($metrics), 200, [
            'Content-Type' => RenderTextFormat::MIME_TYPE,
        ]);
    }
}
