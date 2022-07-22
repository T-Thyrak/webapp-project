<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/course.css') }}" rel="stylesheet"> --}}
</head>
<body>
    <div class="course-viewport">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="mx-2">
                    <img src="{{asset('images/logo.png')}}" alt="SmartCut Logo" width="64" height="64">
                </div>
                <a class="navbar-brand" href="#">Smartcut</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>

                    @if (Route::has('courses'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('courses') }}">Courses</a>
                        </li>
                    @endif                   
                    </ul>
                </div>
            </div>
        </nav>

        <hr>

        <div class="course-container">
            <div class="course-header">
                <div class="course-header-title">
                    <h2 class="course-h2">{{ $course->name }}</h2>
                    <h1 class="course-h1">{{ $lesson->title }}</h1>
                </div>
            </div>
            <div class="course-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>