@extends('courses.show')

@section('navbar')
    <div class="course-navbar">
        <div class="course-navbar-title">
            <h1>{{ $course->name }}</h1>
        </div>
        <div class="course-navbar-buttons">
            <a href="{{ route('courses.edit', $course->id) }}" class="course-navbar-button">
                <i class="fas fa-edit"></i>
            </a>
            <a href="{{ route('courses.destroy', $course->id) }}" class="course-navbar-button">
                <i class="fas fa-trash-alt"></i>
            </a>
        </div>
    </div>
@endsection