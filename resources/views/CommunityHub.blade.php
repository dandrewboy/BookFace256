@extends('layouts.navbar')
@section('title')
@section('content')
<h4>Affinity Groups</h4>
<br/>
<div>
<table class="table">
<tr>
<td>Group Name</td>
<td>Discription</td>
<td>Join/Leave</td>
<td>View Group</td>
<td>Delete</td>
</tr>
@foreach ($groupArray as $group)
<tr>
<td>{{$group['NAME']}}</td>
<td>{{$group['DISCRIPTION']}}</td>
<td>
@if($memberGID == $group['GROUPID'])
<form method="post" action="doLeaveGroup">
{{csrf_field()}}<input type="hidden" value="{{$memberID}}" name="id"></input>
<button class="btn btn-primary" type="submit">Leave</button>
</form>
@else
<form method="post" action="doJoinGroup">
{{csrf_field()}}<input type="hidden" value="{{$group['GROUPID']}}" name="id"></input>
<button class="btn btn-primary" type="submit">Join</button>
</form>
@endif
</td>
<td>
<form method="get" action="doViewGroup">
{{csrf_field()}}<input type="hidden" value="{{$group['GROUPID']}}" name="id"></input>
<button class="btn btn-primary" type="submit">View</button>
</form>
</td>
 @if(Session::get('UserID') == $group['user_userID'])
<td>
<form method="post" action="doDeleteGroup">
{{csrf_field()}}<input type="hidden" value="{{$group['GROUPID']}}" name="id"></input>
<button class="btn btn-primary" type="submit">Delete</button>
</form>
</td>
@endif
</tr>
@endforeach
<tr>
</tr>
</table>
<form action="addgroup">
<button class="btn btn-primary" type="submit" value="add">New Group</button>
</form>
</div>
@endsection