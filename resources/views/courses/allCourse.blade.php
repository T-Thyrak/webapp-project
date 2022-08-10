@extends('layouts.navbar')

@section('title', 'All Course')

@section('content')

    <div class="container">

        <div class="outer-grid">
            <div class="grid-container">
                @foreach ($courses as $item)
                    <div class="card">
                        <div class="grid-item">
                            <div class="img-container">
                                <img class="card-img-top " src="{{ asset('uploads/course_images/' . $item->image) }}"
                                    alt="Card image cap">
                            </div>

                            <div class="card-body ">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <a href="#" class="btn btn-primary">Start Now</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
