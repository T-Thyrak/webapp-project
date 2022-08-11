@extends('layouts.navbar')

@section('title', 'Course')

@section('content')
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
@endsection