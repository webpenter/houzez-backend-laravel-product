<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;

interface InsightRepositoryInterface
{
    public function recordPropertyView(string $slug): JsonResponse;
    public function getInsightProperties(): JsonResponse;
    public function getPropertyViews(int $id): JsonResponse;
    public function getPropertyUniqueViews(int $id): JsonResponse;
    public function getChartStats(int $id): JsonResponse;
    public function getDeviceStats(int $id): JsonResponse;
    public function getCountriesStats(int $id): JsonResponse;
    public function getPlatformStats(int $id): JsonResponse;
    public function getBrowsersStats(int $id): array;
    public function storeRecentView(string $slug): JsonResponse;
    public function getRecentViews(): JsonResponse;
}
