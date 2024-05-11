@extends('layouts.dashboard')
@section('content')
    <div class="row ">
        <div class="col-12 mb-3 mt-3">
            <div class="card h-100">
                <img src="{{ asset("files/posts/$post->post_image") }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->content }}</p>
                    @if ($post->files !== null)
                        <ul> files :
                            @foreach ($post->files as $files)
                                <li> <a href="{{ asset("files/posts/file/$files") }}"
                                        style="text-decoration: none">{{ $files }}</a> </li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="d-flex justify-content-between">
                        <p class="card-text">@lang('Post user') :<a href="{{ route('user.profile', $post->user->name) }}"
                                style="text-decoration: none"> {{ $post->user->name }} </a></p>
                        <p class="card-text"> Category name : <a
                                @if ($post->category !== null) href="{{ route('category.show', $post->category->id) }}" >{{ $post->category->name }}</a> @endif
                                </p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <small class="text-muted">@lang('Created at') : {{ $post->created_at->diffforhumans() }}</small>
                    <small class="text-muted">@lang('Last updated') : {{ $post->updated_at->diffforhumans() }}</small>
                    @if (Auth::user() == $post->user)
                        <div class="d-flex justify-content-between ">
                            <a href="{{ route('posts.edit', $post->id) }}" style="color: white;text-decoration: none;">
                                <button type="submit" class="btn btn-success">
                                    @lang('Edit')
                                </button></a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">@lang('Delete') </button>
                            </form>
                        </div>
                    @endif

                </div>
                <hr>
                @foreach ($post->comments as $comments)
                    <div class="card">
                        <div class="card-body mt-4">
                            <p class="card-text">{{ $comments->content }}</p>
                            @if ($comments !== null && $comments->like !== null)
                                @foreach ($comments->like as $like)
                                    <p class="text-muted "> like : {{ $like->like }} <i class="fas fa-thumbs-up"
                                            style="color: rgb(83, 83, 233)"></i></p>
                                    <p class="text-muted ">dis : {{ $like->dislike }} <i class="fas fa-thumbs-down"
                                            style="color: rgb(230, 121, 121)"></i></p>
                                    <p class="text-muted "> last like or dislike at :
                                        {{ $like->updated_at->diffforhumans() }}</p>
                                    <p class="text-muted "> last like or dislike by :
                                        <a href="{{ route('user.profile', $like->user->name) }}"
                                            style="text-decoration: none"> {{ $like->user->name }}</a>
                                    </p>
                                @endforeach
                            @endif
                            <div class="text-muted mb-4">commented Since :
                                {{ $comment->created_at->diffforhumans() }} ,
                                @lang ('By') : <a href="{{ route('user.profile', $comments->user->name) }}"
                                    style="text-decoration: none"> {{ $comments->user->name }}</a>
                            </div>
                            <div class="d-flex justify-content-between ">
                                @if (Auth::user() == $comments->user)
                                    <form action="{{ route('comment.destroy', $comments->id) }}" method="post">
                                        {{-- <form method="post"> --}}
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger" type="submit" id="delete_comment">Delete
                                            Comment </button>
                                    </form>
                                @endif
                                @auth
                                    <div class="d-flex justify-content-between ">
                                        <form id="add-like-form" action="{{ route('comment.like', $comments->id) }}"
                                            method="GET">
                                            {{-- <form id="add-like-form"> --}}
                                            {{-- @csrf --}}
                                            {{-- @method('put') --}}
                                            <input type="number" name="user_id" value="{{ $comments->user->id }}" hidden>
                                            <input type="number" name="comment_id" value="{{ $comments->id }}" hidden>
                                            <input type="number" name="post_id" value="{{ $post->id }}" hidden>
                                            <button class="" type="submit"><i class="fas fa-thumbs-up"
                                                    style="color: rgb(83, 83, 233)"></i> </button>
                                        </form>
                                        <form method="post" action="{{ route('comment.dislike', $comments->id) }}">
                                            @csrf
                                            {{-- @method('put') --}}
                                            <input type="number" name="user_id" value="{{ $comments->user->id }}" hidden>
                                            <input type="number" name="comment_id" value="{{ $comments->id }}" hidden>
                                            <input type="number" name="post_id" value="{{ $post->id }}" hidden>
                                            <button class="" type="submit"><i class="fas fa-thumbs-down"
                                                    style="color: rgb(230, 121, 121)"></i> </button>
                                        </form>
                                    </div>
                                @endauth
                                @guest
                                    <p class="text text-success"><a href="{{ route('login') }}" style="text-decoration: none">
                                            login </a> or <a href="{{ route('register') }}"
                                            style="text-decoration: none">register </a> to like or dislike </p>
                                @endguest

                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                @if ($post->status == 'close')
                    <h3>@lang('Comment are Close for this post')</h3>
                @endif
                @if ($post->status == 'active')
                    <h4>@lang('Send Your Comment')</h4>
                    <form action="{{ route('comment.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="form-group">
                            <div>
                                <textarea type="text" class="form-control @error('content') is-invalid @enderror" name="content"></textarea>
                                @error('content')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @auth
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-3 mb-2">@lang('Add Comment')</button>
                            </div>
                        @endauth
                    </form>
                    @guest
                        <p class="text text-success"><a href="{{ route('login') }}" style="text-decoration: none">
                                Login </a> or<a href="{{ route('register') }}" style="text-decoration: none"> register
                            </a> to comment</p>
                    @endguest
                @endif

            </div>
            {{--
            <script>
                $(document).ready(function() {

                    var form = '#add-like-form';

                    $(form).on('submit', function(event) {
                        event.preventDefault();
                        var comment_id = $("input[name=comment_id]").val();
                        var post_id = $("input[name=post_id]").val();
                        // var id = $("input[name=comment_id]").val();
                        var url = "{{ route('comment.like', ':id') }}";
                        url = url.replace(':id', comment_id);

                        $.ajax({
                            url: url,
                            method: 'GET',
                            data: {
                                comment_id: comment_id,
                                post_id: post_id,
                            },
                            success: function(response) {
                                alert(response.success);
                            }
                        });
                    });

                });
            </script> --}}
        @endsection
