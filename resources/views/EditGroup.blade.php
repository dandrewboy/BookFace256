@extends('layouts.navbar')
@section('title', 'Edit Group Page')

@section('content')
<form action="doEditGroup" method="post">
<h2 align="center">Edit Group</h2>
<input type = "hidden" name = "post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
<br>
{{csrf_field()}}<input type="hidden" value="{{$id}}" name="id"></input>
Group Name: <br>
<input type="text" name="name" maxlength="20"><br><br>
Description: <br>
<input type="text" name="description" maxlength="250"><br><br>
<button type="submit">Edit Group</button>
</form>
@endsection
