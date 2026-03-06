<?php

namespace App\Http\Repositories\Eloquent\Admin;

use App\Http\ServicesLayer\Admin\HomeServices\HomeService;
use App\Http\Repositories\Eloquent\Admin\BaseAdminRepository;

class HomeRepository extends BaseAdminRepository
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function crudName(): string
    {
        return '';
    }

    public function home(){
        return $this->homeService->home();
    }

    public function target(Request $request)
    {
        // return $this->targetRepository->search($request);
    }

}
