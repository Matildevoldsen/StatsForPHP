<?php

namespace StatsPHP\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use StatsPHP\Interfaces\StatsInterface;

class StatsService
{
    public function getStats(StatsInterface $model): array
    {
        return $model->getStats();
    }

    public function getNewRecordsInTheLastMonth(Model $model): int
    {
        return $model->where(
            'created_at', '>=', Carbon::now()->subMonth()
        )->count();
    }

    public function getNewRecordsInTheLastQuarter(Model $model): int
    {
        return $model->where(
            'created_at', '>=', Carbon::now()->subQuarter()
        )->count();
    }

    public function getNewRecordsInTheLastYear(Model $model): int
    {
        return $model->where(
            'created_at', '>=', Carbon::now()->subYear()
        )->count();
    }

    public function getPercentageOfNewRecordsComparedWithLastMonth(Model $model): float
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $lastMonthRecords = $model->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

        $thisMonthRecords = $this->getNewRecordsInTheLastMonth($model);

        $growthPercentage = ($thisMonthRecords - $lastMonthRecords) / $lastMonthRecords * 100;

        return $growthPercentage;
    }

    public function getPercentageOfNewRecordsComparedWithMonths(Model $model, int $monthsAgo): float
    {
        $monthsAgoStart = Carbon::now()->subMonths($monthsAgo)->startOfMonth();
        $monthsAgoEnd = Carbon::now()->subMonths($monthsAgo)->endOfMonth();

        $monthsAgoRecords = $model->whereBetween('created_at', [$monthsAgoStart, $monthsAgoEnd])->count();

        $recentRecords = $this->getNewRecordsInTheLastMonth($model);

        return ($recentRecords - $monthsAgoRecords) / $monthsAgoRecords * 100;
    }
}
