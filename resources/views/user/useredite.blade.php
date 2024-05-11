@extends('layouts.dashboard')
@section('content')


        <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="formGroupExampleInput"
                    value="{{ $user->name }}">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="formGroupExampleInput"
                    value="{{ $user->email }}" >
            </div>
            <div class="mb-3">
                <label for="user_image" class="form-label">Image</label>
                <input class="form-control" type="file" id="user_image" name="user_image">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit </button>
            </div>


        </form>
    </div>
@endsection
