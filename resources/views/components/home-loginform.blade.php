<div class="col-12 col-sm-6 col-md-4">
    <div class="card shadow-sm card-bg-transparent">
        <div class="header">Login</div>
        <form id="form-login" class="w-100 p-4">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label style="display:none" for="username"></label>
                <input type="name" name="id_loginid" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username" autocomplete="on">
            </div>
            <div class="form-group">
                <label style="display:none" for="password"></label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="on">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" name="remember" for="exampleCheck1">Remember me</label>
                <a class="forgot-pass" href="{{ route('password.request') }}">Forgot password?</a>
            </div>

            <div class="login-field mt-3">
                <button type="button" class="btn btn-primary w-100" id="btn-login">LOGIN</button>
            </div>
            <div class="login-field mt-2">
                <a href="{{ route('register') }}" class="btn btn-secondary w-100" id="btn-register">Create a free account</a>
            </div>
        </form>
    </div>
    <a href="{{ route('download') }}" class="w-100">
        <img src="{{ asset('storage/img/download.png') }}" alt="download" class="img-fluid mt-2">
    </a>
</div>
