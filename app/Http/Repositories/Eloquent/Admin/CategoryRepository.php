<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Category;
use DevxPackage\AbstractRepository;

class CategoryRepository extends AbstractRepository
{

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'categories';
    }

    public function index($offset, $limit)
    {
        return $this->pagination($offset, $limit);
    }

    public function pagination($offset, $limit)
    {
        return $this->model->with($this->model->model_relations())->withCount($this->model->model_relations_counts())->unArchive()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
    }

    public function create(){}

    public function edit($id){}

    public function archivesPage($offset, $limit){}

}