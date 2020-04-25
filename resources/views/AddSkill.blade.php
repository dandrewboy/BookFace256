@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doAddSkill" method="post">
<h2 align="center">Add Skill</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
Title: <br>
<input type="text" name="Title" maxlength="10"><br><br>
Description: <br>
<input type="text" name="Description" maxlength="250"><br><br>
<button type="submit">Add Skill</button>
</form>
@endsection
