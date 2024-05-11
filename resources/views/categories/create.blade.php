@extends('layouts.dashboard')
@section('content')
    <h2 style="text-align: center" class="text mt-3 mb-5"> Create new Category
    </h2>
    <div class="container">

        <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="formGroupExampleInput"
                    placeholder="Category Name">
            </div>
            <div class="mb-3">
                <select class="form-select" aria-label="Default select example" name="parent_id">
                    <option selected value="">Select Parent</option>
                    @if ($categories)
                        @foreach ($categories as $categories)
                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                        @endforeach
                    @endif

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
