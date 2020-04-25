@extends('layouts.navbar')
@section('title')
@section('content')
<h4>Job Information</h4>
<br/>
<div>
Company: {{$job[0]['COMPANY']}}<br/>
Position: {{$job[0]['POSITION']}}<br/>
Description: {{$job[0]['DESCRIPTION']}}<br/>
</div>
<h4><a class="nav-link" href="search">Go Back</a></h4>
<form action="apply" method="get">
<button class="btn btn-primary" type="submit">Apply</button>
</form>
@endsection
