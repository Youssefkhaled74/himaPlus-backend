<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\CategoryRepository;
use App\Http\Repositories\Eloquent\Admin\CountryRepository;
use App\Http\Repositories\Eloquent\Admin\HomeRepository;
use App\Http\Repositories\Eloquent\Admin\UserRepository;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
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
        $term = trim((string) ($request->get('q', $request->get('term', ''))));

        return User::query()
            ->select(['id', 'name'])
            ->where('user_type', 2)
            ->whereNull('deleted_at')
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery->where('name', 'like', '%' . $term . '%')
                        ->orWhere('id', 'like', '%' . $term . '%');
                });
            })
            ->orderByDesc('id')
            ->limit(PAGINATION_COUNT)
            ->get();
    }

    public function countries(Request $request)
    {
        $term = trim((string) ($request->get('q', $request->get('term', ''))));

        return Country::query()
            ->select(['id', 'name'])
            ->whereNull('deleted_at')
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery->where('name', 'like', '%' . $term . '%')
                        ->orWhere('id', 'like', '%' . $term . '%');
                });
            })
            ->orderByDesc('id')
            ->limit(PAGINATION_COUNT)
            ->get();
    }

    public function categories(Request $request)
    {
        $term = trim((string) ($request->get('q', $request->get('term', ''))));

        return Category::query()
            ->select(['id', 'name'])
            ->whereNull('deleted_at')
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($innerQuery) use ($term) {
                    $innerQuery->where('name', 'like', '%' . $term . '%')
                        ->orWhere('id', 'like', '%' . $term . '%');
                });
            })
            ->orderByDesc('id')
            ->limit(PAGINATION_COUNT)
            ->get();
    }

}
