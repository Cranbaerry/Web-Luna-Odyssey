@extends('layouts.main')
@section('content')
    <div class="row">
        <form method="POST" class="m-auto tile w-100" action="{{ route('login') }}">
            @csrf
            <div class="px-5 py-4">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
                <div class="subtitle">Login</div>
                <div class="article pb-3" style="text-indent: 0;">Please fill in this form to log into your account!</div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input name="id_loginid" type="name" class="form-control" id="inputEmail3" placeholder="Username" value="{{ old('id_loginid') }}" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Log In</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
