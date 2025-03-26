<?php

namespace App\Repositories;

use App\Http\Requests\Others\ReplyMessageRequest;
use App\Models\MessageReply;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;;
use App\Models\TourRequest;

interface TourRequestRepositoryInterface
{
    /**
     * Retrieve messages where the user is either the sender or the property owner.
     *
     * @param  int  $userId
     * @return AnonymousResourceCollection
     */
    public function showMessages(int $userId): AnonymousResourceCollection;

    /**
     * Send a message related to a tour request.
     *
     * @param array $data
     * @return TourRequest
     */
    public function sendMessage(array $data): TourRequest;

    /**
     * Delete a tour request (message) if the user is authorized.
     *
     * @param  int  $userId  The authenticated user ID.
     * @param  int  $messageId  The ID of the message to delete.
     * @return JsonResponse  A response indicating success or failure.
     */
    public function deleteMessage(int $userId, int $messageId): JsonResponse;

    /**
     * Retrieve details of a single message if the user is authorized.
     *
     * @param  int  $userId
     * @param  int  $messageId
     * @return JsonResponse
     */
    public function showMessageDetail(int $userId, int $messageId): JsonResponse;

    /**
     * Store a new reply message.
     *
     * @param ReplyMessageRequest $request
     * @return MessageReply
     */
    public function replyToMessage(ReplyMessageRequest $request): MessageReply;

    /**
     * Fetch all replies for a specific tour request.
     *
     * @param int $tourRequestId
     * @return Collection
     */
    public function getReplies(int $tourRequestId): Collection;

}
