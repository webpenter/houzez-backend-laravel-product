<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\GeneralSettingRequest;
use App\Repositories\GeneralSettingRepositoryInterface;

class GeneralSettingController extends Controller
{
    protected $generalSettingRepository;

    public function __construct(GeneralSettingRepositoryInterface $generalSettingRepository)
    {
        $this->generalSettingRepository = $generalSettingRepository;
    }

    public function store(GeneralSettingRequest $request)
    {
        $settings = $this->generalSettingRepository->createOrUpdate($request->validated());
        return response()->json($settings);
    }
}