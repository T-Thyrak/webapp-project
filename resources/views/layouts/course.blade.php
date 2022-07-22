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
        <div class="course-container">
            <div class="course-header">
                <div class="course-header-image">
                    <div class="container d-flex align-items-center justify-content-center">
                        <div class="course-header-image-inner"><img src="{{ $course->image }}" alt="SmartCut"></div>
                    </div>
                </div>
                <div class="course-header-title">
                    <h1 class="course-h1">{{ $course->name }}</h1>
                </div>
            </div>

            <div class="course-body">
                <div class="course-body-content">
                    <div class="course-body-content-about-question">
                        <h2>About this course</h2>
                    </div>
                    <div class="course-body-content-about">
                        <p class="course-text">{{ $course->description }}</p>
                    </div>
                </div>

                <div class="wrapper">
                    <div class="center-line">
                        <a href="#" class="scroll-icon"><i class="fas fa-caret-up"></i></a>
                    </div>
                    @foreach ($lessons as $lesson)
                        <div class="row row-2">
                            <section>
                                @if ($lesson->type == 'video')
                                    <i class="icon fa-solid fa-video"></i>
                                @elseif ($lesson->type == 'text')
                                    <i class="icon fa-solid fa-pen-ruler"></i>
                                @elseif ($lesson->type == 'quiz')
                                    <i class="icon fa-solid fa-clipboard-list"></i>
                                @elseif ($lesson->type == 'course_final')
                                    <i class="icon fa-solid fa-certificate"></i>
                                @endif

                                <div class="details">
                                    <a class="title nav-link" href="{{
                                        route('courses.show', [
                                            'course' => $course->slug,
                                            'lesson' => $lesson->slug,
                                        ])
                                    }}">{{ $lesson->title }}</a>
                                </div>
                            </section>
                        </div>
                    @endforeach
                    {{-- <div class="row row-2">
                        <section>
                            <i class="icon fas fa-home"></i>
                            <div class="details">
                                <span class="title">Title of Section 1</span>
                                <span>1st Jan 2021</span>
                            </div>
                            <p>Lorem ipsum dolor sit ameters consectetur adipisicing elit. Sed qui veroes praesentium maiores, sint eos vero sapiente voluptas debitis dicta dolore.</p>
                            <div class="bottom">
                                <a href="#">Read more</a>
                                <i>- Someone famous</i>
                            </div>
                        </section>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>