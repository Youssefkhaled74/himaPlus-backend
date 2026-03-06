<?php

namespace App\Http\Repositories\Eloquent\Admin;

use DevxPackage\AbstractRepository;

abstract class BaseAdminRepository extends AbstractRepository
{
    public function delete($id)
    {
        return $this->model->where("id", $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
    }

    public function searchByColumn($request)
    {
        $query = $request->get('q');
        $record = $request->get('record');
        $records = [];
        $allowedColumns = $this->allowedSearchColumns();

        if (!is_null($query) && in_array($record, $allowedColumns, true)) {
            $records = $this->model
                ->with($this->model->model_relations())
                ->withCount($this->model->model_relations_counts())
                ->where($record, '=', $query)
                ->unArchive()
                ->limit(PAGINATION_COUNT)
                ->get();
        }

        return $records;
    }

    public function archivesSearch($request)
    {
        $query = $request->get('q');
        $records = [];

        if (!is_null($query)) {
            $searchButton = 0;
            $records = $this->model
                ->with($this->model->model_relations())
                ->withCount($this->model->model_relations_counts())
                ->archive()
                ->modelSearch($query)
                ->get();
        } else {
            $searchButton = 1;
            $records = $this->model
                ->latest()
                ->with($this->model->model_relations())
                ->withCount($this->model->model_relations_counts())
                ->archive()
                ->limit(PAGINATION_COUNT)
                ->get();
        }

        if ($records && count($records) > 0) {
            $records[0]->searchButton = $searchButton;
        }

        return $records;
    }

    public function archivesSearchByColumn($request)
    {
        $query = $request->get('q');
        $record = $request->get('record');
        $records = [];
        $allowedColumns = $this->allowedSearchColumns();

        if (!is_null($query) && in_array($record, $allowedColumns, true)) {
            $records = $this->model
                ->with($this->model->model_relations())
                ->withCount($this->model->model_relations_counts())
                ->where($record, '=', $query)
                ->archive()
                ->limit(PAGINATION_COUNT)
                ->get();
        }

        return $records;
    }

    protected function allowedSearchColumns(): array
    {
        $default = ['id', 'is_activate', 'deleted_at', 'created_at', 'updated_at'];
        if (!method_exists($this->model, 'fildes')) {
            return $default;
        }

        $columns = array_keys((array) $this->model->fildes());
        return array_values(array_unique(array_merge($default, $columns)));
    }
}


