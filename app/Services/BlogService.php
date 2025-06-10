<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    /**
     * Get all blogs
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Blog::latest()->get();
    }

    /**
     * Get a blog by ID
     *
     * @param int $id
     * @return Blog
     */
    public function getById(int $id): Blog
    {
        return Blog::findOrFail($id);
    }

    /**
     * @param array $data
     * @return Blog
     */
    public function store(array $data): Blog
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->saveImage($data['image']);
        }

        return Blog::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Blog
     */
    public function update(int $id, array $data): Blog
    {
        $blog = Blog::findOrFail($id);

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->saveImage($data['image']);
        }

        $blog->update($data);
        return $blog;
    }

    /**
     * Save uploaded image and return full URL
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function saveImage(\Illuminate\Http\UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->move(public_path('blog-images'), $fileName);

        return url('blog-images/' . $fileName); // Full URL
    }

    /**
     * Delete a blog
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Blog::findOrFail($id)->delete();
    }

    /**
     * Get app blogs
     *
     * @return Collection
     */
    public function getAppBlogs(): Collection
    {
        return Blog::latest()->take(10)->get();
    }
}
