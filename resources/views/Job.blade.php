@extends('layouts.navbar')
@section('title')
@section('content')
<h4>Job Information</h4>
<div>
<table class="table">
<tr>
<td>Company</td>
<td>Position</td>
<td>Description</td>
<br/>
<td>EDIT</td>
<td>DELETE</td>
</tr>
<tbody>
@foreach ($jobArray as $job)
<tr>
<td>{{$job->getCompany()}}</td>
<td>{{$job->getPosition()}}</td>
<td>{{$job->getDescription()}}</td>
<td>
<td>
<form method = "post" action="doJobPass">
{{csrf_field()}}<input type="hidden" value="{{$job->getJobID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="active">Edit</button>
</form>
</td>
<td>
<form method="post" action="doJobDelete">
{{csrf_field()}}<input type="hidden" value="{{$job->getJobID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="delete">Delete</button>
</form>
</td>
<td></td>
</tr>
@endforeach
</tbody>
</table>
<form action="addjob">
	<button type="submit">New Job</button>
</form>
</div>
@endsection