<?php

namespace App\Repositories;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
interface ActivityRepositoryInterface
{
    public function getUserReviews(): AnonymousResourceCollection;
    public function getLeadsSummary(): array;
    public function getDealsSummary(): array;
    public function getEnquiriesSummary(): array;
}
