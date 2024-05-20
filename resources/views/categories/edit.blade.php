@extends('layouts.dashboard')
@section('content')
    <h2 style="text-align: center" class="text mt-3 mb-5"> Edit {{ $category->name }}
    </h2>
    <div class="container">

        <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="formGroupExampleInput"
                    value="{{ $category->name }}" placeholder="Category Name">
            </div>
            <div class="mb-3">
                <select class="form-select" aria-label="Default select example" name="parent_id">
                    <option selected>Select Parent</option>
                    @foreach ($categories as $categories)
                        <option value="{{ $categories->id }}" @if ($categories->id == $category->parent_id) selected @endif>
                            {{ $categories->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category_img" class="form-label">Default file input example</label>
                <input class="form-control" type="file" id="category_img" name="category_img">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit </button>
            </div>


        </form>
    </div>
@endsection
