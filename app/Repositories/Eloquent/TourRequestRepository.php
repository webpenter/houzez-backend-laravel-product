<?php

namespace App\Repositories\Eloquent;

use App\Http\Requests\Others\ReplyMessageRequest;
use App\Http\Resources\Others\TourRequestResource;
use App\Models\MessageReply;
use App\Models\TourRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Repositories\TourRequestRepositoryInterface;

class TourRequestRepository implements TourRequestRepositoryInterface
{
    /**
     * Retrieve messages where the user is either the sender or the property owner.
     *
     * @param  int  $userId
     * @return AnonymousResourceCollection
     */
    public function showMessages(int $userId): AnonymousResourceCollection
    {
        $messages = TourRequest::where('user_id', $userId)
            ->orWhereHas('property', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return TourRequestResource::collection($messages);
    }

    /**
     * Store and return a new tour request.
     *
     * @param array $data
     * @return TourRequest
     */
    public function sendMessage(array $data): TourRequest
    {
        return TourRequest::create($data);
    }

    /**
     * Delete a tour request (message) if the user is authorized.
     *
     * @param  int  $userId  The authenticated user ID.
     * @param  int  $messageId  The ID of the message to delete.
     * @return JsonResponse  A response indicating success or failure.
     */
    public function deleteMessage(int $userId, int $messageId): JsonResponse
    {
        $message = TourRequest::find($messageId);

        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        if ($message->user_id !== $userId && $message->property->user_id !== $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted successfully'], 200);
    }

    /**
     * Retrieve details of a single message if the user is authorized.
     *
     * @param  int  $userId
     * @param  int  $messageId
     * @return JsonResponse
     */
    public function showMessageDetail(int $userId, int $messageId): JsonResponse
    {
        $message = TourRequest::find($messageId);

        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        if ($message->user_id !== $userId && $message->property->user_id !== $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(new TourRequestResource($message));
    }

    /**
     * Store a new reply message.
     *
     * @param ReplyMessageRequest $request
     * @return MessageReply
     */
    public function replyToMessage(ReplyMessageRequest $request): MessageReply
    {
        return MessageReply::create([
            'tour_request_id' => $request->tour_request_id,
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);
    }

    /**
     * Fetch all replies for a specific tour request.
     *
     * @param int $tourRequestId
     * @return Collection
     */
    public function getReplies(int $tourRequestId): Collection
    {
        return MessageReply::where('tour_request_id', $tourRequestId)->with('user')->latest()->get();
    }
}
