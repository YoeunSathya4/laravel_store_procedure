@extends('cp.layouts.auth')

@section('title', 'Login')

@section('pagecontent')
    <?php if (session('flashmessage')) : ?>
    <div style="max-width: 322px; margin: 0 auto">
    <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {{ session('flashmessage') }}
    </div>  
    </div>
    <?php endif; ?>

    @if ($errors->has('email'))
        <div style="max-width: 322px; margin: 0 auto">
            <div class="alert alert-danger alert-no-border alert-close alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ $errors->first('email') }}
            </div>  
        </div>
    <?php endif; ?>

    <form action="{{ route('cp.auth.authenticate') }}" method="POST" class="sign-box" id="form-signin_v1" name="form-signin_v1" method="POST" >
        <div style="width: 300px !important;" class="sign-avatar">
            <img src="{{ asset ('public/cp/img/logo.png') }}"  alt="">
        </div>
        <header class="sign-title">Log In for User</header>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input  type="email" 
                    value ="admin@camcyber.com" 
                    class="form-control" 
                    placeholder="Enter Email or Phone Number"
                    required
                    name="email" />
        </div>
        <div class="form-group">
            <input type="password" 
                    class="form-control" 
                    value = "123456"
                    placeholder="Enter Your Password"
                    required
                    name="password" />
        </div>
        <div class="form-group">
            <div class="checkbox float-left">
                <input type="checkbox" id="signed-in" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="signed-in">Keep me signed in</label>
            </div>
            <div class="float-right reset">
                <!--<a href="{{ route('cp.auth.forgot-password') }}">Reset Password</a>-->
            </div>
        </div>
        <button type="submit" class="btn btn-inline">Log In  {{Auth::guard()->check()}}</button>
    </form>

    <script type="text/javascript">
        //window.location.href = "http://www.w3schools.com";
    </script>
@endsection
