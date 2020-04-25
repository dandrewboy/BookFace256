@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doEditSkill" method="post">
<h2 align="center">Edit Job</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
{{csrf_field()}}<input type="hidden" value="{{$id}}" name="id"></input>
Title: <br>
<input type="text" name="Title" maxlength="10"><br><br>
Description: <br>
<input type="text" name="Description" maxlength="250"><br><br>
<button type="submit">Edit Skill</button>
</form>
@endsection