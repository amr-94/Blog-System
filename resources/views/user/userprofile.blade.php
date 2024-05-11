@extends('layouts.dashboard')
@section('content')
    {{-- @if (Auth::user()->type == 'admin') --}}
    <div class="row">
        <div class="col-md-12 ">
            <div class="card h-100">

                @if ($user->image !== null)
                    <img src="{{ asset("files/user/$user->image") }}" class="img-fluid" width="100%" style="">
                @else
                    <img src="{{ asset('profile_photo/') }}" width="100%" />
                @endif
                <div class="d-flex justify-content-between">

                    <p><b> @lang('User Name') :</b>{{ $user->name }}</p>
                    <p><b>@lang('Email') :</b>{{ $user->email }}</p>
                    <p><b>@lang('type') :</b>{{ $user->type }}</p>
                    <p><b>@lang('weather degree') :</b>{{ $temp }}</p>
                    <p><b>@lang('weather status') :</b>{{ $weather }}</p>
                    <p><b>@lang('wind speed') :</b>{{ $wind }}</p>
                </div>
                @if ($user == Auth::user())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                @if ($user->id !== Auth::user()->id)
                                    <a href="{{ route('user.message') }}" class="btn  btn-outline-success"> messages </a>
                                @endif
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-outline-dark">@lang('Edit')
                                </a>
                            </div>
                            <form method="post" action="{{ route('logout') }}" class="delete-form">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"> @lang('logout')</button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>

        </div>


        @foreach ($user->posts as $post)
            <div class="col-12 col-sm-4 mb-3 mt-3">
                <div class="card h-100">
                    <img src="{{ asset("files/posts/$post->post_image") }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"> <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                        </h5>
                        <p class="card-text">{{ $post->content }}</p>
                        <div class="justify-content-between">
                            <p class="card-text"> comments num : {{ $post->comments->count() }}</p>
                            <p class="card-text"> Category name : <a
                                    href="{{ route('category.show', $post->category->id) }}"
                                    style="text-decoration: none">{{ $post->category->name }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <small class="text-muted">Created at : {{ $post->created_at->diffforhumans() }}</small>
                        <small class="text-muted">Last updated : {{ $post->updated_at->diffforhumans() }}</small>
                    </div>
                    @if ($post->user == Auth::user())
                        <div class="d-flex justify-content-between ">
                            <button type="submit" class="btn btn-success">
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    style="color: white;text-decoration: none;">@lang('Edit')
                                </a></button>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">@lang('Delete') </button>
                            </form>
                        </div>
                    @endif

                </div>

            </div>
        @endforeach
    </div>
    @auth
        @if (Auth::user()->name !== $user->name)
            <div class="card mb-3">
                <div class="card-body">
                    <p style="text-align: center">message to {{ $user->name }}</p>

                    <form action="{{ route('user.send') }}" method="post" class="form sendmessage">
                        @csrf
                        <input type="text" hidden class="form-control" id="exampleFormControlInput1" placeholder="title"
                            name="to_user_id" value="{{ $user->id }}">

                        <div class="mb-3">
                            <label for="title" class="form-label"> Title of message</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="title"
                                name="title">
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label"> Content of message</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                            @error('content')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">send</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth
@endsection
