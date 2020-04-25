@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doJobPost" method="post">
<h2 align="center">Add Job</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
Company: <br>
<input type="text" name="company" maxlength="10"><br><br>
Position: <br>
<input type="text" name="position" maxlength="20"><br><br>
Description: <br>
<input type="text" name="description" maxlength="250"><br><br>
<button type="submit">Add Job</button>
</form>
@endsection
