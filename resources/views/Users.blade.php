@extends('layouts.navbar')
@section('title')
@section('content')
<h4>User Information</h4>
<div>
<table class="table">
<tr>
<td>Username</td>
<td>Role</td>
<td>Status</td>
<br/>
<td>ACTIVE</td>
<td>DELETE</td>
</tr>
<tbody>
@foreach ($userArray as $user)
@if($user['userID'] != \Session::get('UserID'))
<tr>
<td>{{$user['username']}}</td>
<td>{{$user['ROLE']}}</td>
<td>{{$user['ACTIVE']}}</td>
@if(!$user['ACTIVE']==1)
<td>
<form method="post" action="stateChange">
{{csrf_field()}}<input type="hidden" value="{{$user['userID']}}" name="id"></input>
<input type="hidden" value="{{$user['ACTIVE']}}" name="status"></input>
<button class="btn btn-primary" type="submit" value="unactive">Unactive</button>
</form>
</td>
@else
<td>
<form method="post" action="stateChange">
{{csrf_field()}}<input type="hidden" value="{{$user['userID']}}" name="id"></input>
<input type="hidden" value="{{$user['ACTIVE']}}" name="status"></input>
<button class="btn btn-primary" type="submit" value="active">Active</button>
</form>@endif
</td>
<td>
<form method="post" action="deleteUser">
{{csrf_field()}}<input type="hidden" value="{{$user['userID']}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="delete">Delete</button>
</form>
</td>
<td></td>
</tr>
@endif
@endforeach
</tbody>
</table>
</div>
@endsection