@extends('admin.layouts.notlogged')

@section('content')
    <div class="wrapper">
        <li><a href="{{ url('/register') }}">Register</a></li>

        {!! Form::open(['url' => '/login', 'class' => 'form-signin', 'name' => 'loginForm']) !!}
            <h2 class="form-signin-heading">Please login</h2>

            <div class="form-group{!! $errors->has('email') ? ' has-error' : '' !!}">
                {!! Form::email('email', null, ['class' => 'form-control', 'autofocus', 'placeholder' => 'Email Address']) !!}
            </div>

            <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <div class="checkbox">
                    {!! Form::checkbox('remember') !!} Remember me
                </div>
            </div>

            <div class="form-group">
                {!! Form::button('Login', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary btn-block']) !!}
                {!! link_to('/password/reset', 'Forgot Your Password?', ['class' => 'btn btn-link']) !!}
            </div>
        {!! Form::close() !!}

    </div>
@endsection
