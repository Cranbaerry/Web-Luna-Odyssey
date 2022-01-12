@extends('layouts.main')
@section('content')
    <div class="row">
        <form method="POST" class="m-auto tile w-100" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="px-5 py-4">
                <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
                <div class="subtitle">Password Reset</div>
                <div class="article pb-3" style="text-indent: 0;">Please fill in this form to reset your password!</div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="id_email" type="email" class="form-control" id="inputEmail3" placeholder="E-mail address" value="{{ $request->email }}" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword4" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input name="password_confirmation" type="password" class="form-control" id="inputPassword4" placeholder="Confirm Password">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Reset</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
