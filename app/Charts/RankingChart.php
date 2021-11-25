<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class RankingChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): array
    {
        return $this->chart->barChart()
            ->setTitle('Top 5 Best and Worst')
            ->setSubtitle('')
            ->addData('Nilai 5P', [])
            ->setXAxis([''])
            ->setColors(['#ffc63b', '#ff6384'])
            ->setMarkers(['#FF5722'], 7, 10)
            ->toVue();
    }
}
