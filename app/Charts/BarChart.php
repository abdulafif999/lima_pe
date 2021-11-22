<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class BarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->barChart()
            ->setTitle('Nilai 5P dari Tim 5P yang ada')
            ->addData('Nilai 5P', [10,50,20])
            ->setXAxis(['x','y','z'])
            ->setMarkers(['#FF5722'], 7, 10)
            ->toVue();
    }
}
