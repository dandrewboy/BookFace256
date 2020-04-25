@extends('layouts.navbar')
@section('title', 'Login Page')

@section('content')
<form action="doJobEdit" method="post">
<h2 align="center">Edit Job</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
{{csrf_field()}}<input type="hidden" value="{{$id}}" name="id"></input>
Company: <br>
<input type="text" name="company" maxlength="10"><br><br>
Position: <br>
<input type="text" name="position" maxlength="20"><br><br>
Description: <br>
<input type="text" name="Description" maxlength="250"><br><br>
<button type="submit">Edit Job</button>
</form>
@endsection