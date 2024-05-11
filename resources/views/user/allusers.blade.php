@extends('layouts.dashboard')
@section('content')

    <table class="table">
        <thead>
            <tr>
                <th>image</th>
                <th>ID</th>
                <th>Name</th>
                <th>email</th>
                <th>posts_num</th>
                <th>comments_num</th>
                <th>Created_at</th>
                <th>Updated_at</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($allusers as $allusers)
                <tr>
                    <td>{{ $allusers->id }}</td>
                    <td> <img src="{{ asset("files/user/$allusers->image") }}" width="50" height="50" class="rounded-circle"> </td>
                    <td><a href="{{ route('user.profile', $allusers->id) }}"
                            style="text-decoration: none">{{ $allusers->name }}</a></td>
                    <td>{{ $allusers->email }}</td>
                    <td>
                        @if ($allusers->posts !== null)

                        {{ $allusers->posts->count() }}</a>@endif
                    </td>
                    <td>
                        @if ($allusers->comments !== null)

                        {{ $allusers->comments()->count() }}</a>@endif
                    </td>
                    <td>{{ $allusers->created_at->diffforhumans() }}</td>
                    <td>{{ $allusers->updated_at->diffforhumans() }}</td>
                    <td>
                        <form action="{{ route('deleteuser', $allusers->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
