<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StoreNavBarButton;
use App\Models\NavbarButton;
use App\Repositories\NavbarButtonRepositoryInterface;
use Illuminate\Http\Request;

class NavbarButtonController extends Controller
{
    protected $navbarButtonRepository;

    public function __construct(NavbarButtonRepositoryInterface $navbarButtonRepository)
    {
        $this->navbarButtonRepository = $navbarButtonRepository;
    }

    /**
     * Get all visible navbar buttons.
     */
    public function getNavbarButtons()
    {
        $navbarButtons = $this->navbarButtonRepository->getAllVisibleButtons();
        return response()->json($navbarButtons);
    }

    /**
     * Get a single navbar button by ID.
     */
    public function showNavbarButton($id)
    {
        $navbarButton = $this->navbarButtonRepository->getButtonById($id);

        if (!$navbarButton) {
            return response()->json(['message' => 'Button not found'], 404);
        }

        return response()->json($navbarButton);
    }

    /**
     * Store a new navbar button.
     */
    public function storeNavbarButton(StoreNavBarButton $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Create and store the new button
        $navbarButton = $this->navbarButtonRepository->createButton($validatedData);

        // Return a response
        return response()->json([
            'message' => 'Navbar button created successfully!',
            'navbar_button' => $navbarButton,
        ], 201);
    }

    /**
     * Update a navbar button by ID.
     */
    public function updateNavbarButton(StoreNavBarButton $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        $navbarButton = $this->navbarButtonRepository->updateButton($id, $validatedData);

        if (!$navbarButton) {
            return response()->json(['message' => 'Button not found'], 404);
        }

        return response()->json([
            'message' => 'Navbar button updated successfully!',
            'navbar_button' => $navbarButton,
        ]);
    }

    /**
     * Update a navbar button visiablity.
     */
    public function updateVisibility(Request $request, $id)
    {
        $request->validate([
            'is_visible' => 'required|boolean',
        ]);

        $button = NavbarButton::findOrFail($id);
        $button->is_visible = $request->is_visible;
        $button->save();

        return response()->json([
            'success' => true,
            'message' => 'Visibility updated successfully.',
            'data' => $button,
        ]);
    }

    /**
     * Delete a navbar button by ID.
     */
    public function deleteNavbarButton($id)
    {
        $navbarButton = $this->navbarButtonRepository->deleteButton($id);

        if (!$navbarButton) {
            return response()->json(['message' => 'Button not found'], 404);
        }

        return response()->json([
            'message' => 'Navbar button deleted successfully!',
        ]);
    }
}
