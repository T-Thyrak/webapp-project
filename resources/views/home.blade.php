@extends('layouts.navbar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="dashboard-header mb-5">
                            <h2>
                                Hello, {{ Auth::user()->name }}!
                            </h2>
                        </div>
                        <div class="dashboard-progress">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $ratio * 100 }}%"
                                    aria-valuenow="{{ $ratio * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress-subtext">
                                <p>
                                    You have completed {{ $ratio * 100 }}% of all courses. Let's keep going!
                                </p>
                            </div>
                        </div>
                        <div class="dashboard-medals">
                            @if (count($amedals) > 0)
                                <h4>
                                    Your medals:
                                </h4>
                                @foreach ($amedals as $key => $value)
                                    <div class="medal-line d-flex">
                                        <i class="fa-solid fa-medal mx-4" style="color:yellowgreen; font-size: 1.4em"></i>
                                        <p>
                                            Completed <b>{{ $value['course_name'] }}</b>
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <h4>
                                    Your medals: None.
                                </h4>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header">{{ __('Settings') }}</div>
                    <div class="card-body">
                        <form
                            action="{{ route('userInfo.update', [
                                'userInfo' => Auth::user()->id,
                            ]) }}"
                            onload="event.preventDefault();" method="PUT" id="update-form">
                            <div class="form-group mb-2">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ Auth::user()->email }}" disabled>
                            </div>
                            <div class="form-group mb-2">
                                <label for="old-password">Old Password *</label>
                                <input type="password" class="form-control" id="old-password" name="old-password" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="new-password">New Password</label>
                                <input type="password" class="form-control" id="new-password" name="new-password">
                            </div>
                            <div class="form-group mb-2">
                                <label for="new-password-confirm">Confirm New Password</label>
                                <input type="password" class="form-control" id="new-password-confirm"
                                    name="new-password-confirm">
                            </div>
                            <button class="btn btn-primary" id="submitv1">Submit</button>
                            <button type="submit" class="btn btn-warning d-none" id="submitv2">Submit (No going
                                back)</button>
                    </div>
                    </form>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        {{ __('Danger Territory' ) }}
                    </div>
                    <div class="card-body">
                        <button class="btn btn-danger mx-2" onclick="promoteLecturer()"> Temporarily Promote to Lecturer </button>
                        <button class="btn btn-danger mx-2" onclick="demoteLecturer()"> Temporarily Demote to Lecturer </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on("keypress", "form", e => {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });

        $("#update-form").submit(function() {
            return false;
        });

        $("#submitv1").click(function() {
            if ($("#name").val() == "" || $("#old-password").val() == "") {
                alert("Please fill in the required fields (Name and Old Password).");
                return false;
            }
            $("#submitv1").addClass("d-none");
            $("#submitv2").removeClass("d-none");
        });

        $("#submitv2").click(function() {
            if ($("#name").val() == "" || $("#old-password").val() == "") {
                alert("Please fill in the required fields (Name and Old Password).");
                return false;
            }

            var name = $("#name").val();
            var old_password = $("#old-password").val();
            var new_password = $("#new-password").val();
            var new_password_confirm = $("#new-password-confirm").val();

            var response = updateUserInfo(name, old_password, new_password, new_password_confirm);

            if (response.status == "success") {
                Swal.fire({
                    title: "Success!",
                    text: "Your information has been updated.",
                    icon: "success",
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.message,
                    icon: "error",
                    timer: 2000,
                });
            }
        });

        function updateUserInfo(name, old_password, new_password, new_password_confirm) {
            var resp;
            var settings = {
                "async": false,
                "url": "{{ route('userInfo.update', [
                    'userInfo' => Auth::user()->id,
                ]) }}",
                "method": "PUT",
                "headers": {
                    "Content-Type": "application/json",
                },
                "data": JSON.stringify({
                    "name": name,
                    "old-password": old_password,
                    "new-password": new_password,
                    "new-password-confirm": new_password_confirm,
                }),
                "success": response => {
                    resp = response;
                }
            };

            $.ajax(settings);

            return resp;
        }

        function promoteLecturer() {
            var resp;

            var settings = {
                "async": false,
                "url": "{{ route('isLecturer.update', [
                    'isLecturer' => Auth::user()->id,
                ]) }}",
                "method": "PUT",
                "headers": {
                    "Content-Type": "application/json",
                },
                "data": JSON.stringify({
                    "is_lecturer": true,
                    "user_id": "{{ Auth::user()->id }}",
                }),
                "success": response => {
                    resp = response;
                }
            }

            $.ajax(settings);

            Swal.fire({
                title: "Success!",
                text: "You have been promoted to lecturer.",
                icon: "success",
                timer: 2000,
            });

            return resp;
        }

        function demoteLecturer() {
            var resp;

            var settings = {
                "async": false,
                "url": "{{ route('isLecturer.update', [
                    'isLecturer' => Auth::user()->id,
                ]) }}",
                "method": "PUT",
                "headers": {
                    "Content-Type": "application/json",
                },
                "data": JSON.stringify({
                    "is_lecturer": false,
                    "user_id": "{{ Auth::user()->id }}",
                }),
                "success": response => {
                    resp = response;
                }
            }

            $.ajax(settings);

            Swal.fire({
                title: "Success!",
                text: "You have been demoted from Lecturer.",
                icon: "success",
                timer: 2000,
            });

            return resp;
        }
    </script>
    </div>
@endsection
