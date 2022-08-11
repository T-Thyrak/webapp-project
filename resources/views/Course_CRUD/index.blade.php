@extends('layouts.navbar')

@section('title', 'CRUD course')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <h6 class="alert alert-success">{{ session('status') }}</h6>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Course CRUD
                            <a href="{{ url('add-course-item') }}" class="btn btn-primary float-end">Add Course</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course name</th>
                                    <th>Course Description</th>
                                    <th>Image</th>
                                    <th>Course Slug</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            {{-- <img src="{{ asset('uploads/course_images/' . $item->image) }}" alt="Image"
                                                width="70px" height="70px"> --}}
                                                <img src="{{ $item->image }}" alt="{{ $item->title }}" width="64px" height="64px">
                                        </td>
                                        <td>{{ $item->slug }}</td>
                                        <td>
                                            <a href="{{ url('/edit-course-item/' . $item->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/delete-course-item/' . $item->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
