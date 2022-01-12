@extends('layouts.main')
@section('content')
    <div class="row">
        <form method="POST" class="m-auto tile w-100" action="{{ route('password.email') }}">
            @csrf
            <div class="px-5 py-4">
                <x-auth-session-status class="alert alert-info" :status="session('status')" />
                <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
                <div class="subtitle">Password Reset</div>
                <div class="article pb-3" style="text-indent: 0;">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</div>


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="id_email" type="email" class="form-control" id="inputEmail3" placeholder="E-mail address" value="{{ old('id_email') }}">
                    </div>
                </div>


                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Send Reset Link</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
