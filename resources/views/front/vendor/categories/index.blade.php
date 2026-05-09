@extends('layouts.front.home')
@section('title')<title>Vendor Categories</title>@endsection
@section('content')
<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">?????????</h3>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('vendor/categories/store') }}" enctype="multipart/form-data" class="row g-2">
                @csrf
                <div class="col-md-5"><input type="text" name="name" class="form-control" placeholder="??? ???????" required></div>
                <div class="col-md-5"><input type="file" name="img" class="form-control" accept="image/*"></div>
                <div class="col-md-2"><button class="btn btn-primary w-100">?????</button></div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        @forelse($categories as $category)
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>{{ $category->name }}</h5>
                        @if(!empty($category->img))<img src="{{ asset(ltrim($category->img,'/')) }}" style="height:60px" class="mb-2" alt="cat">@endif
                        <div class="small text-muted mb-2">?????? ??? ?????? ???? ???????:</div>
                        <ul class="mb-0">
                            @forelse($category->products as $p)
                                <li><a href="{{ route('vendor/products/show',$p->id) }}">{{ $p->name }}</a></li>
                            @empty
                                <li class="text-muted">?? ???? ??????</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-light">?? ???? ???????</div></div>
        @endforelse
    </div>
</main>
@endsection
