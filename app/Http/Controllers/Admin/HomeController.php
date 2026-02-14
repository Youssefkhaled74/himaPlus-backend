<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\CategoryRepository;
use App\Http\Repositories\Eloquent\Admin\CountryRepository;
use App\Http\Repositories\Eloquent\Admin\HomeRepository;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public $home;
    public $userRepository;
    public $categoryRepository;
    public $countryRepository;

    public function __construct(HomeRepository $home, CategoryRepository $categoryRepository, CountryRepository $countryRepository, UserRepository $userRepository)
    {
        $this->home = $home;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository = $countryRepository;
    }

    public function home()
    {
        return $this->home->home();
    }

    public function users(Request $request)
    {
        return $this->userRepository->search($request);
    }

    public function countries(Request $request)
    {
        return $this->countryRepository->search($request);
    }

    public function categories(Request $request)
    {
        return $this->categoryRepository->search($request);
    }

}
