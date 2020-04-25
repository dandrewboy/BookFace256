@extends('layouts.navbar')
@section('title')
@section('content')
<h4>Job Listings</h4>
<form action = "doJobSearch" method = "get">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
	<div>
		<button type="submit" name="search">Search</button>
	</div>
	<div> 
		<input type="text" placeholder="Search for job" name="search"></input>
	</div>
</form>
@endsection