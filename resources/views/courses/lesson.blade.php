@extends('layouts.lesson')

@section('content')
    @if ($lesson->type == 'text')
    @php
        $curl = curl_init();

        // echo $_ENV['GITHUB_LESSON_BASE'] . $course->slug . '/' . $lesson->slug . '.md';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $_ENV['GITHUB_LESSON_BASE'] . $course->slug . '/' . $lesson->slug . '.md',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    @endphp
        {!!
            app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($response);
        !!}
    @elseif ($lesson->type == 'video')
        <div class="d-flex align-items-center justify-content-center">
            <div class="embed-responsive embed-responsive-16by9">
                <div id="player"></div>
            </div>
        </div>

        @php
            $curl = curl_init();

            // echo $_ENV['GITHUB_LESSON_BASE'] . $course->slug . '/' . $lesson->slug . '.md';

            curl_setopt_array($curl, array(
                CURLOPT_URL => $_ENV['GITHUB_LESSON_BASE'] . $course->slug . '/' . $lesson->slug . '.md',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        @endphp
            {!!
                app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($response);
            !!}

        <script id="mainScript">
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementById('mainScript');
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            var player;
            function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                    height: '390',
                    width: '640',
                    videoId: '{{ $lesson->video_link }}',
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerReady(event) {
                // event.target.playVideo();
            }

            function onPlayerStateChange(event) {
                
            }

            function gotoTime(time) {
                player.seekTo(time);
            }

        </script>
    @elseif ($lesson->type == 'quiz')
        @php
            $quizzes = App::make('App\Http\Controllers\QuizController')->randomQuiz($course->id, $lesson->id, 5);
        @endphp

        @for ($i = 0; $i < count($quizzes); $i++)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">{{ $quizzes[$i]->question }}</h5>
                    <span id="question{{$i}}-type">{{ $quizzes[$i]->type }}</span>
                </div>
                <div class="card-body">
                    @if ($quizzes[$i]->attachment != null)
                        <img src="{{$quizzes[$i]->attachment}}" width="640" height="480">
                    @endif
                    @if ($quizzes[$i]->type == 'multiple')
                        <form>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-1" value="1">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_1 }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-2" value="2">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_2 }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-3" value="3">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_3 }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-4" value="4">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_4 }}
                                    </label>
                                </div>
                            </div>
                        </form>
                    @else
                        <form>
                            <textarea name="question{{$i}}" id="question{{$i}}-s" cols="30" rows="10"></textarea>
                        </form>
                    @endif
                </div>
            </div>
        @endfor

        <button class="btn btn-primary" onclick="submitQuiz()">Submit</button>

        <script>
            function submitQuiz() {
                var answers = [];
                var questions_id = [
                    @foreach ($quizzes as $quiz)
                        {{ $quiz->id }},
                    @endforeach
                ];
                var questions = document.getElementsByTagName('form');
                for (var i = 0; i < questions.length - 1; i++) {
                    console.log(`question${i}-type`);
                    if (document.getElementById(`question${i}-type`).innerHTML == 'multiple') {
                        var selectedValue = document.querySelector(`input[name="question${i}"]:checked`).value;
                        if (selectedValue == null) {
                            alert(`Please answer question ${i + 1}`);
                            return;
                        } else {
                            console.log(`pushed question ${i + 1} with answer ${selectedValue}`);
                            answers.push({
                                'question': questions_id[i],
                                'answer': selectedValue,
                            });
                        }
                    } else {
                        var selectedValue = document.getElementById(`question${i}-s`).value;
                        if (selectedValue == '') {
                            alert(`Please answer question ${i + 1}`);
                            return;
                        } else {
                            console.log(`pushed question ${i + 1} with answer ${selectedValue}`);
                            answers.push({
                                'question': questions_id[i],
                                'answer': selectedValue,
                            });
                        }
                    }
                }

                var quizAnswers = {
                    'answers': answers,
                    'course_id': {{ $course->id }},
                    'lesson_id': {{ $lesson->id }},
                    'user_id': {{ Auth::user()->id }},
                };

                var data = JSON.stringify(quizAnswers);
                
                var settings = {
                    "url": "{{ route('checkQuiz.check') }}",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": data,
                    "success": response => {
                        console.log(response);
                        if (response.correct == true) {
                            Swal.fire({
                                title: "Correct!",
                                text: "You have completed this lesson!",
                                icon: "success",
                                timer: 2000,
                            });
                        } else {
                            Swal.fire({
                                title: "Incorrect!",
                                text: "Try again!",
                                icon: "error",
                                timer: 2000,
                            });
                        }
                    }
                };

                $.ajax(settings);
            }
        </script>
    @else
        @php
            $quizzes = App::make('App\Http\Controllers\QuizController')->randomQuiz($course->id, 15);
        @endphp

        @for ($i = 0; $i < count($quizzes); $i++)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">{{ $quizzes[$i]->question }}</h5>
                    <span id="question{{$i}}-type">{{ $quizzes[$i]->type }}</span>
                </div>
                <div class="card-body">
                    @if ($quizzes[$i]->attachment != null)
                        <img src="{{$quizzes[$i]->attachment}}" width="640" height="480">
                    @endif
                    @if ($quizzes[$i]->type == 'multiple')
                        <form>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-1" value="1">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_1 }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-2" value="2">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_2 }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-3" value="3">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_3 }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="question{{$i}}" id="question{{$i}}-4" value="4">
                                    <label class="form-check-label" for="question{{$i}}">
                                        {{ $quizzes[$i]->answer_4 }}
                                    </label>
                                </div>
                            </div>
                        </form>
                    @else
                        <form>
                            <textarea name="question{{$i}}" id="question{{$i}}-s" cols="30" rows="10"></textarea>
                        </form>
                    @endif
                </div>
            </div>
        @endfor

        <button class="btn btn-primary" onclick="submitQuiz()">Submit</button>

        <script>
            function submitQuiz() {
                var answers = [];
                var questions_id = [
                    @foreach ($quizzes as $quiz)
                        {{ $quiz->id }},
                    @endforeach
                ];
                var questions = document.getElementsByTagName('form');
                for (var i = 0; i < questions.length - 1; i++) {
                    console.log(`question${i}-type`);
                    if (document.getElementById(`question${i}-type`).innerHTML == 'multiple') {
                        var selectedValue = document.querySelector(`input[name="question${i}"]:checked`).value;
                        if (selectedValue == null) {
                            alert(`Please answer question ${i + 1}`);
                            return;
                        } else {
                            console.log(`pushed question ${i + 1} with answer ${selectedValue}`);
                            answers.push({
                                'question': questions_id[i],
                                'answer': selectedValue,
                            });
                        }
                    } else {
                        var selectedValue = document.getElementById(`question{{$i}}-s`).value;
                        if (selectedValue == '') {
                            alert(`Please answer question ${i + 1}`);
                            return;
                        } else {
                            console.log(`pushed question ${i + 1} with answer ${selectedValue}`);
                            answers.push({
                                'question': questions_id[i],
                                'answer': selectedValue,
                            });
                        }
                    }
                }

                var quizAnswers = {
                    'answers': answers,
                    'course_id': {{ $course->id }},
                    'lesson_id': {{ $lesson->id }},
                    'user_id': {{ Auth::user()->id }},
                };

                var data = JSON.stringify(quizAnswers);
                
                var settings = {
                    "url": "{{ route('checkQuiz.check') }}",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": data,
                    "success": response => {
                        console.log(response);
                        if (response.correct == true) {
                            Swal.fire({
                                title: "Correct!",
                                text: "You have passed the course! Go collect your medal!",
                                icon: "success",
                                timer: 2000,
                            });
                        } else {
                            Swal.fire({
                                title: "Incorrect!",
                                text: "Try again!",
                                icon: "error",
                                timer: 2000,
                            });
                        }
                    }
                };

                $.ajax(settings);
            }
        </script>
    @endif
@endsection