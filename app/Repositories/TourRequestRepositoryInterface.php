<?php

namespace App\Repositories;

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
}
