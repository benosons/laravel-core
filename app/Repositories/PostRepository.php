<?php

namespace App\Repositories;

use App\Core\Base\BaseRepository;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
}
