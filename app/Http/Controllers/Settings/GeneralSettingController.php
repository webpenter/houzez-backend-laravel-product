<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreGeneralSettingRequest;
use App\Repositories\GeneralSettingRepositoryInterface;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    protected $generalSettingRepo;

    /**
     * Inject the GeneralSettingRepositoryInterface.
     * This allows flexibility and decouples the controller from a specific repository implementation.
     *
     * @param GeneralSettingRepositoryInterface $generalSettingRepo
     */
    public function __construct(GeneralSettingRepositoryInterface $generalSettingRepo)
    {
        $this->generalSettingRepo = $generalSettingRepo;
    }

    /**
     * Display the general settings.
     *
     * GET /api/settings/general
     *
     * This method returns the first row from the general_settings table,
     * formatted using GeneralSettingResource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->generalSettingRepo->get();
    }

    /**
     * Update general settings.
     *
     * POST or PUT /api/settings/update
     *
     * Validates the incoming request using StoreGeneralSettingRequest,
     * handles file uploads (logo, background image, hero image),
     * saves data into the general_settings table,
     * and returns the updated record in a resource format.
     *
     * @param StoreGeneralSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreGeneralSettingRequest $request)
    {
        return $this->generalSettingRepo->update($request);
    }
}
