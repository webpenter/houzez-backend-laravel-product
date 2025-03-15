<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterSubscribeController extends Controller
{
    /**
     * Subscribe a user to the newsletter.
     *
     * This function handles email subscription by validating the input,
     * checking for existing subscribers, and storing the email in the database.
     *
     * @param Request $request The incoming HTTP request containing the email.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure.
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);

        if ($validator->fails()) {
            return new JsonResponse([
                'message' => 'Please enter a valid email!',
                'errors' => $validator->errors()
            ], 400);
        }

        if (Subscriber::where('email', $request->email)->exists()) {
            return new JsonResponse(['message' => 'You are already subscribed!'], 409);
        }

        $subscriber = Subscriber::create(['email' => $request->email]);

        return new JsonResponse([
            'message' => 'Successfully subscribed.',
            'data' => $subscriber
        ], 200);
    }

    /**
     * Retrieve all newsletter subscribers.
     *
     * @param Request $request The incoming request instance.
     * @return JsonResponse Returns a JSON response containing all subscribers.
     */
    public function getAllSubscribers(Request $request): JsonResponse
    {
        $data = Subscriber::all();
        return new JsonResponse($data);
    }

    /**
     * Delete a specific subscriber by ID.
     *
     * @param int $id The ID of the subscriber to delete.
     * @return JsonResponse Returns a JSON response indicating success or failure.
     */
    public function destroy($id): JsonResponse
    {
        $subscriber = Subscriber::find($id);

        if (!$subscriber) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Subscriber not found',
            ], 404);
        }

        $subscriber->delete();

        return new JsonResponse([
            'success' => true,
            'message' => 'Subscriber deleted successfully',
        ], 200);
    }
}
