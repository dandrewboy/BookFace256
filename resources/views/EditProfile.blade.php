@extends('layouts.navbar')
@section('title', 'Edit Profile')
	
@section('content')
	<form action="doProEdit" method="post">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
	<div>
		<h2 align="center">My Profile</h2>
	</div>
	<div align="center">
		First Name: <br/>
		<input type="text" name="Fname" maxlength="15"/><br/>
	
		Last Name: <br/>
		<input type="text" name="Lname" maxlength="20"/><br/>
	
		Email: <br/>
		<input type="text" name="email" maxlength="25"/><br/>
		
		Phone Number: <br/>
		<input type="text" name="phone"/><br/><br/>
		
		<button type="submit">Submit</button>
	</div>
	</form>
@endsection
