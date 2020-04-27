@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doEditEducation" method="post">
<h2 align="center">Edit Job</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
{{csrf_field()}}<input type="hidden" value="{{$id}}" name="id"></input>
School: <br>
<input type="text" name="School" maxlength="30"><br><br>
Level: <br>
<input type="text" name="Level" maxlength="20"><br><br>
Date: <br>
<input type="date" name="Date" maxlength="8"><br><br>
<button type="submit">Edit Education</button>
</form>
@endsection