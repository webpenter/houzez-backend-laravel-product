<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\Others\ReplyMessageRequest;
use App\Http\Requests\Others\SendTourRequest;
use App\Http\Resources\Others\MessageReplyResource;
use App\Repositories\TourRequestRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    /**
     * Fetch details of a specific tour request (message) if authorized.
     *
     * @param  Request  $request
     * @param  int  $messageId
     * @return JsonResponse
     */
    public function showUserMessageDetail(Request $request, $messageId): JsonResponse
    {
        return $this->tourRequestRepository->showMessageDetail(auth()->id(), $messageId);
    }

    /**
     * Store a reply message.
     *
     * @param ReplyMessageRequest $request
     * @return JsonResponse
     */
    public function replyToMessage(ReplyMessageRequest $request): JsonResponse
    {
        $reply = $this->tourRequestRepository->replyToMessage($request);
        return response()->json([
            'message' => 'Reply sent successfully!',
            'data' => new MessageReplyResource($reply)
        ], 201);
    }

    /**
     * Fetch replies for a given tour request.
     *
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function getReplies(int $id): AnonymousResourceCollection
    {
        $replies = $this->tourRequestRepository->getReplies($id);
        return MessageReplyResource::collection($replies);
    }

}
