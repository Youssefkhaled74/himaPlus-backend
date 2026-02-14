<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Rating;
use DevxPackage\AbstractRepository;

class RatingRepository extends AbstractRepository
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

    public function index($offset, $limit)
    {
        $ratings = $this->pagination($offset, $limit);
        return view('admin.ratings.index', compact('ratings'));
    }

    public function pagination($offset, $limit)
    {
        return $this->model->with($this->model->model_relations())->withCount($this->model->model_relations_counts())->unArchive()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
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