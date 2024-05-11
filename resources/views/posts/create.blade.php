@extends('layouts.dashboard')
@section('content')
    <form class="form" enctype="multipart/form-data" id="add-post-form">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label"> Title</label>
            <input type="text" class="form-control" placeholder="title" name="title">
            @error('title')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">content textarea</label>
            <textarea class="form-control" rows="3" name="content"></textarea>
            @error('content')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="post_img" class="form-label"> post_img</label>
            <input type="file" class="form-control" name="post_img">
            @error('post_img')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <select class="form-select" aria-label="Default select example" name="category_id">
                <option selected value="">Selct Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" name="category_id">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <button class="btn btn-primary btn-submit" type="submit">Save</button>
        </div>
    </form>

    {{-- <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".btn-submit").click(function(e) {

            e.preventDefault();

            var title = $("input[name=title]").val();
            var content = $("textarea[name=content]").val();
            var category_id = $("select[name=category_id]").val();
            var post_img = $("input[name=post_img]").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('posts.store') }}",
                data: {
                    title: title,
                    content: content,
                    category_id: category_id,
                    post_image : post_img
                },
                success: function(data) {
                    alert(data.success);
                }
            });

        });
    </script> --}}

    <script>
        $(document).ready(function() {

            var form = '#add-post-form';

            $(form).on('submit', function(event) {
                event.preventDefault();

                var url = $(this).attr('data-action');

                $.ajax({
                    url: "{{ route('posts.store') }}",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        $(form).trigger("reset");
                        alert(response.success)
                    },
                    error: function(response) {}
                });
            });

        });
    </script>
@endsection
