@extends('layouts.dashboard')
@section('content')
    <h2 style="text-align: center" class="text mt-3 mb-5">
        {{ $posts->count() }} posts from {{ $allpost->count() }}
        @auth
        <a href="{{ route('posts.create') }}" class="btn  btn-outline-primary m-1">Create New post </a> @endauth

    </h2>


    <div class="row mb-4">
        @foreach ($posts as $post)
            <div class="col-12 col-md-4 mt-3">
                <div class="card h-100">
                    <img src="{{ asset("files/posts/$post->post_image") }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"> <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                        </h5>
                        <p class="card-text">{{ $post->content }}</p>
                        <p class="card-text"> user name : <a
                                href="{{ route('user.profile', $post->user->name) }}">{{ $post->user->name }}</a></p>
                        <p class="card-text"> Status : {{ $post->status }}</p>
                        <p class="card-text"> comments num : {{ $post->comments->count() }}</p>
                        <p class="card-text"> Category name : <a
                                @if ($post->category !== null) href="{{ route('category.show', $post->category->id) }}" >{{ $post->category->name }}</a> @endif
                                </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <small class="text-muted">Created at : {{ $post->created_at->diffforhumans() }}</small>
                        <small class="text-muted">Last updated : {{ $post->updated_at->diffforhumans() }}</small>
                    </div>
                    @if (Auth::user() == $post->user)
                        <div class="d-flex justify-content-between ">
                            <button type="submit" class="btn btn-success">
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    style="color: white;text-decoration: none;">Edit
                                </a></button>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">Delete </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    </div>



    {{ $posts->links() }}
@endsection
