@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doAddEducation" method="post">
<h2 align="center">Add Education</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
School: <br>
<input type="text" name="School" maxlength="10"><br><br>
Level: <br>
<input type="text" name="Level" maxlength="20"><br><br>
Date: <br>
<input type="date" name="Date" maxlength="8"><br><br>
<button type="submit">Add Education</button>
</form>
@endsection
