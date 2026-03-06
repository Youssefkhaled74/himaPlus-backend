@extends('layouts.admin.home')

@section('title')
    <title>Ratings</title>
@endsection

@section('css')
@endsection

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent" style="direction: ltr;">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"></li>
                                <li class="breadcrumb-item"><a href="{{route('admin/index')}}">Home</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin/ratings/index')}}/0/{{PAGINATION_COUNT}}">Ratings</a></li>
                                <li class="active" style="color: var(--vz-breadcrumb-item-active-color);">Update</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            @include('flash::message')
            @if ($errors->any())
                <div style="text-align: left; margin: 15px;">
                    <ul dir="ltr">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Update Rating</h4>
                        </div>
                        <div class="card-body">
                            @isset($rating)
                                <form role="form" action="{{url(route('admin/ratings/update', $rating->id))}}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $rating->user_id }}">
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" value="{{ $rating->user?->name ?? '-' }}" placeholder="user" readonly>
                                                <label>User</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" value="{{ $rating->for }} - {{ $rating->forable?->name ?? '-' }}" placeholder="for" readonly>
                                                <label>For</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input name="rating" type="number" step="0.5" min="1" max="5" class="form-control" id="ratingfloatingInput" placeholder="rating" value="{{ old('rating', $rating->rating) }}">
                                                <label for="ratingfloatingInput">Rating <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="commentTextarea">Comment</label>
                                                <textarea name="comment" id="commentTextarea" class="form-control" rows="5">{{ old('comment', $rating->comment) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
<script>
    (function () {
        $('.nav-link.menu-link').removeClass('active');
        $('.menu-dropdown').removeClass('show');
        $('.sidebarratings').addClass('active');
        var target = $('.sidebarratings').attr('href');
        $(target).addClass('show');
    })();
</script>
@endsection
