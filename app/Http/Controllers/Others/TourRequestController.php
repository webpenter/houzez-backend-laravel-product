<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\Others\SendTourRequest;
use App\Repositories\TourRequestRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourRequestController extends Controller
{
    protected TourRequestRepositoryInterface $tourRequestRepository;

    public function __construct(TourRequestRepositoryInterface $tourRequestRepository)
    {
        $this->tourRequestRepository = $tourRequestRepository;
    }

    /**
     * Fetch messages where the user is either sender or property owner.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function showUserMessages(Request $request): JsonResponse
    {
        $messages = $this->tourRequestRepository->showMessages(auth()->id());
        return response()->json($messages);
    }

    /**
     * Handle sending a new tour request message.
     *
     * @param SendTourRequest $request
     * @return JsonResponse
     */
    public function sendMessage(SendTourRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $tourRequest = $this->tourRequestRepository->sendMessage($validated);

        return response()->json(['message' => 'Tour request sent successfully', 'data' => $tourRequest], 201);
    }

    /**
     * Delete a specific tour request (message) if authorized.
     *
     * @param  Request  $request
     * @param  int  $messageId
     * @return JsonResponse
     */
    public function deleteUserMessage(Request $request, $messageId): JsonResponse
    {
        return $this->tourRequestRepository->deleteMessage(auth()->id(), $messageId);
    }
}
