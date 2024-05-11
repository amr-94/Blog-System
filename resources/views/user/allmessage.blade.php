@extends('layouts.dashboard')
@section('content')
    <div class="panel-body">
        <table class="table table-srtiped " style="width: 100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>title</th>
                    <th>content</th>
                    <th>from_user</th>
                    <th>Created_at</th>
                </tr>
            </thead>


            <tbody>
                @foreach ($message as $message)
                    <tr>
                        <td>{{ $message->id }}</td>
                        <td>{{ $message->title }}</td>
                        <td>{{ $message->content }}</td>
                        <td><a
                                href="{{ route('user.profile', [$message->from_user->name]) }}">{{ $message->from_user->name }}</a>
                        </td>
                        <td>{{ $message->created_at->diffforhumans() }}</td>
                        <td>
                            {{-- <form action="{{ route('message.delete', $message->id) }}" method="post" > --}}
                            <form class="delete-form" data-route="{{ route('message.delete', $message->id) }}" >
                                {{-- @method('delete') --}}
                                {{-- @csrf --}}
                                <button class="btn btn-danger">delete</button>

                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            $('.delete-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).data('route'),
                    data: {
                        '_method': 'delete'
                    },
                     success: function(response) {
                      alert(response.success)
                        window.location = '{{ route('user.message') }}'
                    }
                });
            })
        });
    </script>
@endsection
