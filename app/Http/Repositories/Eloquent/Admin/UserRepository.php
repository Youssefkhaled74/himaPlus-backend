<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\User;
use DevxPackage\AbstractRepository;

class UserRepository extends AbstractRepository
{

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'users';
    }

    public function index($offset, $limit)
    {
        return $this->pagination($offset, $limit);
    }

    public function pagination($offset, $limit)
    {
        return $this->model->with($this->model->model_relations())->withCount($this->model->model_relations_counts())->unArchive()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
    }

    public function customUpdate($request, $id)
    {
        $user = $this->model->where("id", $id)->first();
        $request = $this->handle_request($request);

        $request['name'] = $request['name'];
        $request['email'] = $request['email'];
        $request['iban'] = isset($request['iban']) ? $request['iban'] : null;
        $request['branch'] = isset($request['branch']) ? $request['branch'] : null;
        $request['location'] = isset($request['location']) ? $request['location'] : null;
        $request['tax_number'] = isset($request['tax_number']) ? $request['tax_number'] : null;
        $request['cr_number'] = isset($request['cr_number']) ? $request['cr_number'] : null;

        $user->update($request);
        return $user;
    }    
    
    public function handle_request($request)
    {
        $request->password ? $request->merge(['password' => bcrypt($request->password)]) : "";
        if (!$request->hasFile('file') == null) {
            $file = uploadIamge($request->file('file'), $this->crudName()); // function on helper file to upload file
            $request->merge(['img' => $file]);
        }
        if (!$request->hasFile('cr_file_document') == null) {
            $file = uploadIamge($request->file('cr_file_document'), $this->crudName()); // function on helper file to upload file
            $request->merge(['cr_document' => $file]);
        }
        if (!$request->hasFile('files') == null) {
            $files = uploadIamges($request->file('files'), $this->crudName()); // function on helper file to upload file
            $request->merge(['imgs' => $files]);
        }
        $request = array_filter(array_intersect_key($request->all(), $this->model->fildes()));
        return $request;
    }


}