@extends('layouts.dashboard')
@section('content')
    <h2 style="text-align: center" class="text mt-3 mb-5">Categories List : {{ $categories->count() }} Categories <a
            href="{{ route('category.create') }}" class="btn  btn-outline-primary m-1">Create New Category</a>
    </h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>parent_id</th>
                <th>Created_at</th>
                <th>Updated_at</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td><a href="{{ route('category.show', $category->id) }}"
                            style="text-decoration: none">{{ $category->name }}</a></td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        @if ($category->parent_id !== null)
                            <a href="{{ route('category.show', ["$category->id" => "$category->parent_id"]) }}"
                                style="text-decoration: none">
                        @endif{{ $category->parent->name }}</a>
                    </td>
                    <td>{{ $category->created_at->diffforhumans() }}</td>
                    <td>{{ $category->updated_at->diffforhumans() }}</td>


                    <td>
                        <button type="submit" class="btn btn-success btn-sm">
                            <a href="{{ route('category.edit', $category->id) }}"
                                style="color: white ;text-decoration: none;">Edit </a></button>

                    </td>
                    <td>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm">Delete </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection
