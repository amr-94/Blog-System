@extends('layouts.dashboard')
@section('content')
    <h2 style="text-align: center" class="text mt-3 mb-5">

        <p> All Notifications : {{ Auth::user()->notifications->count() }} Notification</p>
        @if (Auth::user()->notifications->count() !== 0)
            <p> UnRead Notifications : {{ Auth::user()->unreadnotifications()->count() }} Notification</p>
        @else
        <p>There are no contifications</p>
                @endif


    </h2>
    <div class="row mb-4">
        <div>
            @foreach ($notifications as $notifications)
                <div class="card my-2">
                    <div class="card-body">

                        @if ($notifications->unread())
                            <a href="{{ route('notify.read', $notifications->id) }}"
                                style="text-decoration: none;color: red">
                        @endif
                        <h4>{{ $notifications->data['title'] }}</h4> </a>
                        <p> {{ $notifications->data['body'] }}</p>
                        <p> user: {{ $notifications->data['user'] }}</p>
                        <p class="text-muted">{{ $notifications->created_at->diffForhumans() }}</p>

                    </div>
                    <form action="{{ route('notification.destroy', $notifications->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger" type="submit">Delete Notification</button>
                    </form>
                </div>
            @endforeach
        </div>

        @if ($notifications->count() !== 0)
            <form action="{{ route('notification.destroyall') }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-outline-primary" type="submit">Clear all Notifications</button>
            </form>
        @endif
    </div>
@endsection
