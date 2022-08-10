@extends('layouts.navbar')

@section('title', 'Add course')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <h6 class="alert alert-success">{{ session('status') }}</h6>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Add Course with Image
                            <a href="{{ url('/crud_course') }}" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('add-course-item') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Course name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Course description</label>
                                <input type="text" class="form-control" name="description">
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Course image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Course slug</label>
                                <input type="text" class="form-control" name="slug">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Save Course
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
