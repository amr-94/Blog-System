@extends('layouts.dashboard')
@section('content')
    <form action="{{ route('posts.update', $post->id) }}" method="post" class="form" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="title" class="form-label"> Title</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" name="title"
                value="{{ $post->title }}">
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content">{{ $post->content }}</textarea>
            @error('content')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="post_img" class="form-label"> post_img</label>
            <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="post_img" name="post_img"
                value="{{ $post->post_image }}">
            @error('post_img')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="post_files" class="form-label"> post_files</label>
            <input type="file" class="form-control" name="post_files[]" multiple>
            @error('post_files')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="category_id">
                <option selected value="">Selct Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }} " @if ($category->id == $post->category_id) selected @endif>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        {{-- <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="status">
                <option selected>Selct status</option>
                 @foreach ($allpost as $allpost)
                    <option value="{{ $allpost->status }} " @if ($allpost->status == $post->status) selected @endif>
                        {{ $allpost->status }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div> --}}
        <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="status">
                <option selected>Selct status</option>
                <option value="active" @if ($post->status == 'active') selected @endif>
                    Active</option>
                <option value="close" @if ($post->status == 'close') selected @endif>
                    Close</option>
            </select>
            @error('category_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
@endsection
