@extends('layouts.main')
@section('content')
    <div class="row">
        <form method="POST" class="m-auto tile w-100" action="{{ route('pin.email') }}">
            @csrf
            <div class="px-5 py-4">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-auth-validation-errors class="alert alert-danger" role="alert" :errors="$errors" />
                <div class="subtitle">PIN Recovery</div>
                <div class="article pb-3" style="text-indent: 0;">Forgot your PIN? No problem. Just let us know your email address and we will email you the registered PIN number.</div>


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="E-mail address" value="{{ old('id_email') }}">
                    </div>
                </div>


                <div class="form-group row">
                    <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Send PIN</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
