<?php

namespace App\Http\Controllers\Api;

use App\Core\Base\BaseController;
use App\Services\PostService;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends BaseController
{
    protected PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $posts = $this->service->getAllPosts();
        return $this->success(PostResource::collection($posts), 'Posts retrieved successfully');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = $this->service->createPost($data);
        return $this->success(new PostResource($post), 'Post created successfully', 201);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->service->getPostById($id);
        if (!$post) {
            return $this->error('Post not found', 404);
        }
        return $this->success(new PostResource($post), 'Post retrieved successfully');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
        ]);

        if ($this->service->updatePost($id, $data)) {
            $post = $this->service->getPostById($id);
            return $this->success(new PostResource($post), 'Post updated successfully');
        }

        return $this->error('Post not found or update failed', 404);
    }

    public function destroy(int $id): JsonResponse
    {
        if ($this->service->deletePost($id)) {
            return $this->success(null, 'Post deleted successfully');
        }

        return $this->error('Post not found', 404);
    }
}
