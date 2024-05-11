                <div class="dropdown text-end">
                    <a href="" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" style="color: white"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge bg-danger" > {{ $user->unreadnotifications()->count() }} </span>
                        UnReadNotification
                    </a>
                    <ul class="dropdown-menu " aria-labelledby="notifications">
                        @foreach ($notifications as $notifications)
                            @if ($notifications->unread())
                                <li><a class="dropdown-item" href="{{ route('notify.read', $notifications->id) }}"
                                        style="text-decoration: none;color: red">
                                        <h6 class="">{{ $notifications->data['title'] }}</h6>
                                        <p class="">{{ $notifications->data['body'] }}</p>
                                        <p class="text-muted">{{ $notifications->created_at->diffForhumans() }}</p>
                                    </a></li>
                            @endif
                        @endforeach
                        @if ($user->unreadnotifications()->count() == 0)
                            <span class="" style="color: rgb(10, 97, 10)">no Unreaded notification </span>
                        @endif
                        <li> <a class="dropdown-item text-muted" href="{{ route('notifay.index') }}"
                                style="text-decoration: none">All notifications</a></li>
                    </ul>

                </div>
