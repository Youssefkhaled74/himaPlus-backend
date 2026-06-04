<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Rating;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class RatingRepository extends BaseAdminRepository
{

    protected $model;

    public function __construct(Rating $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'ratings';
    }

    public function index($offset, $limit, $search = '')
    {
        $ratings = $this->pagination($offset, $limit, $search);
        return view('admin.ratings.index', compact('ratings', 'search'));
    }

    public function pagination($offset, $limit, $search = '')
    {
        return $this->model
            ->with($this->model->model_relations())
            ->withCount($this->model->model_relations_counts())
            ->unArchive()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('comment', 'LIKE', "%{$search}%")
                      ->orWhere('id', 'LIKE', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'LIKE', "%{$search}%");
                      });
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT)
            ->appends(request()->query());
    }

    public function create()
    {
        return view('admin.ratings.create');
    }

    public function edit($id)
    {
        $rating = $this->findOne($id);
        return view('admin.ratings.update', compact('rating'));
    }

    public function archivesPage($offset, $limit)
    {
        $ratings = $this->archives($offset, $limit);
        return view('admin.ratings.archives', compact('ratings'));
    }

}
