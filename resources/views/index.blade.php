@extends('layouts.navbar')

@section('title', ' Home')
@section('content')
    <div class="container">
        {{-- make a centered div  --}}
        <div class="center d-flex mx-auto align-items-center justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h1>SmartCut: Shortcut to being Smart</h1>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Welcome to SmartCut, a platform that helps you to learn and improve your skills.
                        <br>
                        This website is designed for you to learn STEM subjects very quickly and fast.
                        <br>
                        <br>
                        Let's click the <b>Courses</b> button at the top of the navigation bar or the blue button here to see the list of all courses that we have!
                        <br>
                        <br>
                        Happy Learning!
                    </p>
                    <a href="courses" class="btn btn-primary">
                        Courses
                    </a>
                    <br>
                    <div class="d-flex mx-auto align-items-center justify-content-center"><img src="{{asset('images/learning.png')}}" alt="People Learning" height="400"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
