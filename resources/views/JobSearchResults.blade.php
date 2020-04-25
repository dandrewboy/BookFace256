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
<table class="table">
<tr>
<td>Company</td>
<td>Position</td>
<td>Description</td>
<td>View Job</td>
</tr>
<tbody>
@foreach ($jobArray as $job)
<tr>
<td>{{$job['COMPANY']}}</td>
<td>{{$job['POSITION']}}</td>
<td>{{$job['DESCRIPTION']}}</td>
<td>
<form action="doViewJob" method="get">
<input type="hidden" value="{{$job['POSITION']}}" name="pos"></input>
<button class="btn btn-primary" type="submit">View Job</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
