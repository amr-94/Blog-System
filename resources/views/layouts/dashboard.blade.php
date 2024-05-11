<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* body{
                background-color:#131212;
            } */
        /* #bodyofcontent{
                  background-color: #2e2e2e
            }
            {
                background-color: red;
            } */
    </style>

</head>

<body class="sb-nav-fixed">
    <header class="p-3 mb-3 border-bottom bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto  ">
                    @auth
                        <li><a href="{{ route('category.index') }}" class="nav-link px-2 link-secondary"
                                style="color: white">Category</a>
                        </li>
                    @endauth

                    <li><a href="{{ route('posts.index') }}" class="nav-link px-2 link-dark"
                            style="color: white">posts</a></li>
                    @guest
                        <li><a href="{{ route('login') }}" class="nav-link px-2 link-dark" style="color: white">LogIn</a>
                        </li>
                        <li><a href="{{ route('register') }}" class="nav-link px-2 link-dark"
                                style="color: white">Register</a></li>
                    @endguest
                    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"
                        href="#!"><i class="fas fa-bars"></i></button>
                </ul>
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" method="get"
                    action=" {{ route('posts.index') }}">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search"
                        name="search">
                </form>
                <div class="me-2 dropdown text-end">
                    @auth
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1"
                            style="color: white" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('files/user') }}/{{ Auth::user()->image }} " alt="mdo" width="32"
                                height="32" class="rounded-circle">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('user.profile', Auth::user()->name) }}">
                                    @lang('Profile') </a></li>
                            <li><a class="dropdown-item" href="{{ route('posts.create') }}">@lang('add post')</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ URL::current() }}?lang=ar">lang (Ar)</a></li>
                            <li><a class="dropdown-item" href="{{ URL::current() }}?lang=en">lang (En)</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout.form').submit();">Logout</a>
                            </li>
                            @if (Auth::user()->type == 'admin')
                                <li><a class="dropdown-item" href="{{ route('all.users') }}">@lang('All-users')</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
                @auth
                    <x-notify />
                @endauth

            </div>
        </div>
    </header>
    <form id="logout.form" method="POST" action="{{ route('logout') }}">
        @csrf
    </form>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        @auth
                            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle"
                                id="dropdownUser1" style="color: white" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('files/user') }}/{{ Auth::user()->image }} " alt="mdo"
                                    width="32" height="32" class="rounded-circle">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('user.profile', Auth::user()->id) }}">
                                        @lang('Profile') </a></li>
                                <li><a class="dropdown-item" href="{{ route('posts.create') }}">@lang('add post')</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ URL::current() }}?lang=ar">lang (Ar)</a></li>
                                <li><a class="dropdown-item" href="{{ URL::current() }}?lang=en">lang (En)</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout.form').submit();">Logout</a>
                                </li>
                                @if (Auth::user()->type == 'admin')
                                    <li><a class="dropdown-item" href="{{ route('all.users') }}">@lang('All-users')</a>
                                    </li>
                                @endif
                            @endauth
                        </ul>

                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Layouts
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('posts.index') }}">All posts</a>
                                @auth

                                    @if (Auth::user()->type == 'admin')
                                        <a class="nav-link" href="{{ route('category.index') }}">All Categories</a>
                                    @endif

                                    <a class="nav-link"
                                        href="{{ route('user.profile', Auth::user()->name) }}">{{ Auth::user()->name }}
                                        profile</a>
                                @endauth

                            </nav>
                        </div>
                        @guest

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Authentication
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                        aria-controls="pagesCollapseAuth">
                                        login or register
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                        data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                        @endguest

                        <div class="sb-sidenav-menu-heading">Addons</div>
                        @auth

                            <a class="nav-link" href="{{ route('notifay.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                All notify ({{ Auth::user()->notifications->count() }})
                            </a>
                        @endauth

                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                @auth
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as : {{ Auth::user()->type }}</div>
                    </div>
                @endauth

            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div id="bodyofcontent" class="container">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; {{ config('app.name') }} 2022</div>
                        <div>
                            @foreach ($user as $user)
                                Admin / <a href="{{ route('user.profile', $user->name) }}"
                                    style="color: red;text-decoration: none"> {{ $user->name }}</a> &middot;
                            @endforeach
                            {{-- @foreach ($posts as $posts)
                                    <a>posts / {{ $posts->title }}</a> &middot;
                                @endforeach --}}
                            {{ config('app.locale') }}
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> --}}
    {{-- <script src="{{ asset('assets/demo/chart-area-demo.js') }}.js"></script> --}}
    {{-- <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
</body>

</html>
