<?php

namespace App\Repositories\Eloquent;

use App\Http\Resources\Others\TourRequestResource;
use App\Models\TourRequest;
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
}
