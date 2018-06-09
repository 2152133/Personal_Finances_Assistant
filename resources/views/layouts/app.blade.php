<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
            <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <meta content="width=device-width, initial-scale=1" name="viewport">
                    <!-- CSRF Token -->
                    <meta content="{{ csrf_token() }}" name="csrf-token">
                        <title>
                            {{ config('app.name', 'Projeto') }}
                        </title>
                        <!-- Scripts -->
                        <script defer="" src="{{ asset('js/app.js') }}">
                        </script>
                        <!-- Fonts -->
                        <link href="https://fonts.gstatic.com" rel="dns-prefetch">
                            <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
                                <!-- Styles -->
                                <link href="{{ asset('css/app.css') }}" rel="stylesheet">
                                    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
                                    </link>
                                </link>
                            </link>
                        </link>
                    </meta>
                </meta>
            </meta>
        </meta>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <div class="container">
                    @guest
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Finances Assistance
                    </a>
                    @else
                    <a class="navbar-brand" href="{{ route('dashboard', Auth::id()) }}">
                        Finances Assistance
                    </a>
                    @endguest
                    <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarSupportedContent" data-toggle="collapse" type="button">
                        <span class="navbar-toggler-icon">
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li>
                                <a class="nav-link" href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            </li>
                            @else
                            @can('administrate')
                            <li>
                                <a class="nav-link" href="{{ route('users') }}">
                                    {{ __('Edit Users') }}
                                </a>
                            </li>
                            @endcan
                            <li>
                                <a class="nav-link" href="{{ route('user.listProfiles') }}">
                                    {{ __('Show Users') }}
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre="">
                                    {{ __('Groups') }}
                                    <span class="caret">
                                    </span>
                                </a>
                                <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('user.listAssociates') }}">
                                    {{ __('My Group') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('user.listAssociateOf') }}">
                                    {{ __('Groups I belong') }}
                                </a>
                            </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre="">
                                    {{ __('Accounts') }}
                                    <span class="caret">
                                    </span>
                                </a>
                                <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('user.allAccounts', Auth::user()) }}">
                                        {{ __('All Accounts') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.closedAccounts', Auth::user()) }}">
                                        {{ __('Closed Accounts') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.openedAccounts', Auth::user()) }}">
                                        {{ __('Opened Accounts') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.createAccount') }}">
                                        {{ __('Create Account') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('statistics') }}">
                                        {{ __('Statistics') }}
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdown" role="button" v-pre="">
                                    {{ Auth::user()->name }}
                                    <span class="caret">
                                    </span>
                                </a>
                                <div aria-labelledby="navbarDropdown" class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('/') }}">
                                        {{ __('Main Page') }}
                                    </a>
                                    
                                    <a class="dropdown-item" href="{{ route('user.editProfile') }}">
                                        {{ __('Edit Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.editPassword') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>
