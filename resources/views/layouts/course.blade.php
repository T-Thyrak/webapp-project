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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    {{-- <link href="{{ asset('css/course.css') }}" rel="stylesheet"> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="course-viewport">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="mx-2">
                    <img src="{{ asset('images/logo.png') }}" alt="SmartCut Logo" width="64" height="64">
                </div>
                <a class="navbar-brand" href="/">Smartcut</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>

                        <li class="nav-item border">
                            {{-- dropdown:courses --}}
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Courses
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach ($courses as $course)
                                        <a class="dropdown-item"
                                            href="/courses/{{ $course->slug }}">{{ $course->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            {{-- <a href="{{ route('course.allCourses') }}">Courses</a> --}}
                        </li>
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('home') }}" class="dropdown-item">
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <hr>
        <div class="course-container">
            <div class="course-header">
                <div class="course-header-image">
                    <div class="container d-flex align-items-center justify-content-center">
                        <div class="course-header-image-inner"><img class="course-rounded" src="{{ $course->image }}"
                                alt="{{ $course->name }}"></div>
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
                                    <i class="icon fa-solid fa-flag"></i>
                                @endif

                                <div class="details">
                                    <a class="title nav-link"
                                        href="{{ route('courses.show', [
                                            'course' => $course->slug,
                                            'lesson' => $lesson->slug,
                                        ]) }}">{{ $lesson->title }}</a>
                                </div>

                                <p>{{ $lesson->description }}</p>
                            </section>
                        </div>
                    @endforeach
                    <div class="row row-2">
                        <section>
                            @if ($allCompleted)
                                <i class="icon fa-solid fa-certificate"></i>
                                <div class="details">
                                    <a class="title nav-link" href="javascript:syncMedalWrapper()">Click to sync your
                                        medal!</a>
                                </div>
                                <p>Thank you for completing the course about <b>{{ $course->name }}</b>!</p>
                            @else
                                <i class="icon fa-solid fa-certificate inactive"></i>
                                <div class="details">
                                    <p class="title nav-link">You have not yet completed all lessons.</p>
                                </div>
                                <p>Come back later when you have completed all lessons to receive your medal!</p>
                            @endif
                        </section>
                    </div>
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

    <script>
        function syncMedal() {
            var resp = false;

            var settings = {
                "async": false,
                "url": "{{ route('userMedal.check') }}",
                "method": "POST",
                "data": JSON.stringify({
                    "user_id": {{ Auth::user()->id }},
                }),
                "headers": {
                    "Content-Type": "application/json",
                },
                "success": (response) => {
                    if (response.status == 'success') {
                        resp = true;
                    }
                }
            }

            $.ajax(settings);

            return resp;
        }

        function syncMedalWrapper() {
            if (syncMedal()) {
                Swal.fire({
                    title: "Synced medal!",
                    text: "You have successfully synced your medal!",
                    icon: "success",
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Failed to sync medal!",
                    text: "You have not yet completed all lessons.",
                    icon: "error",
                    timer: 2000,
                });
            }
        }

        syncMedal();
    </script>
</body>

</html>
