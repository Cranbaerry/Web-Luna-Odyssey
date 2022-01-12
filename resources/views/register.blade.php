@extends('layouts.main')
@section('content')
    <div class="row tile p-4 mx-0 my-4">
        <div class="col">
            <form method="POST" class="m-auto  w-100" action="{{ route('register') }}">
                @csrf
                <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
                <div class="subtitle">Register</div>
                <div class="article pb-3" style="text-indent: 0;">Please fill in this form to create account!</div>
                <div class="form-group row">
                    <label for="inputUser" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input name="id_loginid" type="name" class="form-control" id="inputUser" placeholder="Username" value="{{ old('id_loginid') }}">
                        <small class="form-text text-muted pl-1">Username can contain any letters or numbers with minimum characters of 4.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="id_email" type="email" class="form-control" id="inputEmail3" placeholder="E-mail address" value="{{ old('id_email') }}">
                        <small class="form-text text-muted pl-1">Please register with an active E-mail for confirmation & rewards claim purposes.</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        <!-- <small class="form-text text-muted pl-1">Avoid using the same or similar Username and Password combination</small> -->
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword4" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                        <input name="password_confirmation" type="password" class="form-control" id="inputPassword4" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPIN" class="col-sm-2 col-form-label">PIN</label>
                    <div class="col-sm-10">
                        <input name="pin" type="password" class="form-control" id="inputPIN" placeholder="PIN Number" maxlength="4" inputmode="numeric" onkeypress="return isNumber(event)" onpaste="return false;">
                        <small class="form-text text-muted pl-1">PIN consists of 4 numbers that will be used for item purchase confirmations and cannot be changed.</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Sign up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
