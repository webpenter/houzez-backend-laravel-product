<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Http\Requests\Others\StoreBlogRequest;
use App\Http\Requests\Others\UpdateBlogRequest;
use App\Http\Resources\Others\BlogResource;
use App\Services\BlogService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    use ResponseTrait;

    protected BlogService $blogService;

    /**
     * BlogController constructor.
     *
     * @param BlogService $blogService
     */
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Get all blogs
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $blogs = $this->blogService->getAll();
        return $this->successResponse(BlogResource::collection($blogs), 'Blogs fetched successfully');
    }

    /**
     * Store a new blog
     *
     * @param StoreBlogRequest $request
     * @return JsonResponse
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        $blog = $this->blogService->store($request->validated());
        return $this->successResponse(new BlogResource($blog), 'Blog created successfully', 201);
    }

    /**
     * Show a single blog
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $blog = $this->blogService->getById($id);
        return $this->successResponse(new BlogResource($blog), 'Blog details');
    }

    /**
     * Update a blog
     *
     * @param UpdateBlogRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateBlogRequest $request, int $id): JsonResponse
    {
        $blog = $this->blogService->update($id, $request->validated());
        return $this->successResponse(new BlogResource($blog), 'Blog updated successfully');
    }

    /**
     * Delete a blog
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->blogService->delete($id);
        return $this->successResponse(null, 'Blog deleted successfully');
    }

    /**
     * Get app blogs
     *
     * @return JsonResponse
     */
    public function getAppBlogs(): JsonResponse
    {
        $blogs = $this->blogService->getAppBlogs();
        return $this->successResponse(BlogResource::collection($blogs), 'App Blogs fetched successfully');
    }
}
