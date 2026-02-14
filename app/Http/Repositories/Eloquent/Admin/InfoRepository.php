<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Models\Info;
use DevxPackage\AbstractRepository;

class InfoRepository extends AbstractRepository
{

    protected $model;

    public function __construct(Info $model)
    {
        $this->model = $model;
    }

    public function crudName(): string
    {
        return 'info';
    }

    public function index($offset, $limit)
    {
        $info = $this->getfirst();
        return view('admin.info.index', compact('info'));
    }

    public function getfirst()
    {
        return $this->model->first();
    }

    public function pagination($offset, $limit)
    {
        return $this->model->with($this->model->model_relations())->withCount($this->model->model_relations_counts())->unArchive()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
    }

    public function create()
    {
        return view('admin.info.create');
    }

    public function edit($id)
    {
        $info = $this->findOne($id);
        return view('admin.info.update', compact('info'));
    }

    public function update($request, $id)
    {
        // $request = $this->handle_request($request);
        // $asks = $request['asks'] ?? null;
        // $terms = $request['terms'] ?? null;
        // $privacy_policies = $request['privacy_policies'] ?? null;
        // $asks = isset($request['asks']) ? json_encode(array_values($request['asks'])) : null;
        // $terms = isset($request['terms']) ? json_encode(array_values($request['terms'])) : null;
        // $privacy_policies = isset($request['privacy_policies']) ? json_encode(array_values($request['privacy_policies'])) : null;
        return $this->model->updateOrCreate(
            ['id' => 1], [
                'mobile' => $request->mobile, 
                'email' => $request->email, 
                'location' => $request->location,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'snapchat' => $request->snapchat,
                'tiktok' => $request->tiktok,
                'vat' => $request->vat, 
                'desc' => $request->desc, 
                'message' => $request->message, 
                'vision' => $request->vision, 
                'asks' => $request->asks ?? null, 
                'abouts' => $request->abouts ?? null, 
                'terms' => $request->terms ?? null, 
                'privacy_policies' => $request->privacy_policies ?? null, 
            ]
        );
    }

    public function archivesPage($offset, $limit)
    {
        $info = $this->archives($offset, $limit);
        return view('admin.info.archives', compact('info'));
    }

}