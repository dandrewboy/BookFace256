@extends('layouts.navbar')
@section('title')
@section('content')
<h4>Members</h4>
<br/>
<div>
<table class="table">
<tr>
<td>First Name</td>
<td>Last Name</td>
</tr>
@foreach ($memberArray as $member)
@if($member['groups_GROUPID'] == $groupID)
<tr>
<td>{{$member['FIRSTNAME']}}</td>
<td>{{$member['LASTNAME']}}</td>
</tr>
@endif
@endforeach
</table>
</div>
<h4><a class="nav-link" href="home">Go Back</a></h4>
@endsection
