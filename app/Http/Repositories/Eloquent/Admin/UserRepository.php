<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\User;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class UserRepository extends BaseAdminRepository
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

    public function index($offset, $limit, $userType = '', $search = '', $isActivate = '', $createdToday = '')
    {
        return $this->pagination($offset, $limit, $userType, $search, $isActivate, $createdToday);
    }

    public function pagination($offset, $limit, $userType = '', $search = '', $isActivate = '', $createdToday = '')
    {
        return $this->model
            ->with($this->model->model_relations())
            ->withCount($this->model->model_relations_counts())
            ->unArchive()
            ->when($userType !== '', function ($query) use ($userType) {
                $query->where('user_type', (int) $userType);
            })
            ->when($isActivate !== '', function ($query) use ($isActivate) {
                $query->where('is_activate', (int) $isActivate);
            })
            ->when($createdToday !== '', function ($query) {
                $query->whereDate('created_at', now()->toDateString());
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('mobile', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(PAGINATION_COUNT)
            ->appends(request()->query());
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
        if ($request->hasFile('cr_document')) {
            $file = uploadIamge($request->file('cr_document'), $this->crudName()); // function on helper file to upload file
            $request->merge(['cr_document' => $file]);
        } elseif ($request->hasFile('cr_file_document')) {
            $file = uploadIamge($request->file('cr_file_document'), $this->crudName()); // backward compatibility with old field name
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
