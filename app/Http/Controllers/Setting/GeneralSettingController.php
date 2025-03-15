<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\GeneralSettingRequest;
use App\Repositories\GeneralSettingRepositoryInterface;
use Illuminate\Http\JsonResponse;

class GeneralSettingController extends Controller
{
    protected $generalSettingRepository;

    public function __construct(GeneralSettingRepositoryInterface $generalSettingRepository)
    {
        $this->generalSettingRepository = $generalSettingRepository;
    }


    public function index()
    {
        $settings = $this->generalSettingRepository->getSettings();
        return response()->json($settings);
    }


    public function createOrUpdateGeneralSettings(GeneralSettingRequest $request): JsonResponse
    {
        $settings = $this->generalSettingRepository->createOrUpdateGeneralSettings($request->validated());
        return response()->json(['message' => 'Settings saved successfully', 'data' => $settings]);
    }
    
}