@extends('layouts.dashboard')
@section('content')
    <div class="container">

        <h2 style="text-align: center" class="text mb-3">({{ $category->posts->count() }})Posts For This Category </h2>
        <div class="row ">
            @foreach ($category->posts as $post)
                <div class="col-6 col-md-4 mb-3 ">
                    <div class="card h-100">
                        <img src="{{ asset("files/posts/$post->post_image") }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"> <a
                                    href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                            </h5>
                            <p class="card-text">{{ $post->content }}</p>
                            <div class="d-flex justify-content-between">
                                <p class="card-text"> user name : {{ $post->user->name }}</p>
                                <p class="card-text"> Category name : <a
                                        href="{{ route('category.show', $post->category->id) }}">{{ $post->category->name }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <small class="text-muted">Created at : {{ $post->created_at }}</small>
                            <small class="text-muted">Last updated : {{ $post->updated_at }}</small>
                        </div>
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
                    </div>

                </div>
            @endforeach
        </div>
    @endsection
