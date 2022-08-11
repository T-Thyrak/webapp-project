@extends('layouts.navbar')

@section('title')
    {{ $course->name }}
@endsection

@section("content")
    <div class="course-viewport">
        <div class="course-container">
            <div class="course-header">
                <div class="course-header-title">
                    <h2 class="course-h2">{{ $course->name }}</h2>
                    <h1 class="course-h1">{{ $lesson->title }}</h1>
                </div>
            </div>
            <div class="course-body">
                @yield('lesson-content')
            </div>
        </div>
    </div>

    <script>
        var codeBlocks = document.getElementsByClassName('language-cpp');
        for (let elem of codeBlocks) {
            shiki.getHighlighter({
                theme: 'monokai',
            }).then(highlighter => {
                var code = highlighter.codeToHtml(elem.innerText, 'cpp');

                elem.parentNode.insertAdjacentHTML("beforeBegin", code);
                elem.parentNode.remove();
            });
        }

        var tables = document.getElementsByTagName('table');
        for (let table of tables) {
            table.classList.add('table', 'table-striped', 'table-bordered', 'table-hover');
        }
    </script>
@endsection