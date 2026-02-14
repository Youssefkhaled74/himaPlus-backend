<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Contact;
use DevxPackage\AbstractRepository;

class ContactRepository extends AbstractRepository
{

    protected $model;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'contacts';
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