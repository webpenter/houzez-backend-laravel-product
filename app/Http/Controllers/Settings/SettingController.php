<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingRequest;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    protected $settings;

    public function __construct(SettingRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get all settings
     */
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'All settings retrieved successfully',
            'data'    => $this->settings->all(),
        ], 200);
    }

    /**
     * Store or update a setting
     */
    public function store(SettingRequest $request): JsonResponse
    {
        $setting = $this->settings->updateOrCreate($request->validated());

        return new JsonResponse([
            'success' => true,
            'message' => 'Setting saved successfully',
            'data'    => $setting,
        ], 201);
    }

    /**
     * Show a specific setting
     */
    public function show(string $key): JsonResponse
    {
        $setting = $this->settings->get($key);

        if (!$setting) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Setting not found',
            ], 404);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Setting retrieved successfully',
            'data'    => $setting,
        ], 200);
    }

    public function socialLinks()
    {
        $links = $this->settings->getVisibleSocialLinks();

        return new JsonResponse([
            'success' => true,
            'message' => 'Social links retrieved successfully',
            'data'    => $links,
        ]);
    }
    }
