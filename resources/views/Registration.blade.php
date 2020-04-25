@extends('layouts.appmaster')
@section('title', 'Login Page')

@section('content')
<form action="onRegister" method="post">
<h2 align="center">Register</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
First Name: <br>
<input type="text" name="Fname" maxlength="10"></input>{{ $errors->first('username') }}<br><br>
Last Name: <br>
<input type="text" name="Lname" maxlength="10"></input>{{ $errors->first('username') }}<br><br>
Username: <br>
<input type="text" name="Uname" maxlength="10"></input>{{ $errors->first('username') }}<br><br>
Password: <br>
<input type="password" id="pw1" name="pw" maxlength="10"></input>{{ $errors->first('username') }}<br><br>
<button type="submit">Register</button>
</form>
<p align="center" id="login">If you already have an account, click <a href="Login"> here</a></p>
@endsection
