@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doAddGroup" method="post">
<h2 align="center">Add Group</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
Group name: <br>
<input type="text" name="name" maxlength="20"><br><br>
Description: <br>
<input type="text" name="discription" maxlength="250"><br><br>
<button type="submit">Add Group</button>
</form>
@endsection
