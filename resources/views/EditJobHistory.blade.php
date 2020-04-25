@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doEditJobHistory" method="post">
<h2 align="center">Edit Job</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
{{csrf_field()}}<input type="hidden" value="{{$id}}" name="id"></input>
Title: <br>
<input type="text" name="Title" maxlength="10"><br><br>
Company: <br>
<input type="text" name="Company" maxlength="20"><br><br>
Date: <br>
<input type="date" name="Date" maxlength="8"><br><br>
<button type="submit">Edit Job History</button>
</form>
@endsection