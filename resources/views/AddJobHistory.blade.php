@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doAddJobHistory" method="post">
<h2 align="center">Add Job History</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
Title: <br>
<input type="text" name="Title" maxlength="10"><br><br>
Company: <br>
<input type="text" name="Company" maxlength="20"><br><br>
Date: <br>
<input type="date" name="Date" maxlength="10"><br><br>
<button type="submit">Add Job History</button>
</form>
@endsection
