<?php

namespace App\Services;

use App\Core\Base\BaseService;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostService extends BaseService
{
    protected PostRepositoryInterface $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPosts(): Collection
    {
        return $this->repository->all();
    }

    public function createPost(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function getPostById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function updatePost(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function deletePost(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
