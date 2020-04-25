@extends('layouts.navbar')
@section('title', 'Profile Page')
	
@section('content')
	<form action="editpro">
<input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>"/>
	<div>
		<h2 align="center">My Profile</h2>
	</div>
	<div align="center">
	<table>
	<tr>
	<td>
		First Name: <br/>
		{{\Session::get('Firstname')}}<br/>
	
		Last Name: <br/>
		{{\Session::get('Lastname')}}<br/>
	@foreach ($ProfileArray as $profile)
		Email: <br/>
		{{$profile['email']}}<br/>
		
		Phone Number: <br/>
		{{$profile['phonenumber']}}<br/>
	@endforeach
		</td>
		</tr>
		</table>
		</div>
		<div id="portfolio">
			<button type="submit">Edit</button><br />
	</div>
</form>
<h4>My Job History</h4>
<div>
<table class="table">
<tr>
<td>Title</td>
<td>Company</td>
<td>Date</td>
<br/>
<td>EDIT</td>
<td>DELETE</td>
</tr>
<tbody>
@foreach ($JobHistoryArray as $jobHistory)
<tr>
<td>{{$jobHistory->getTitle()}}</td>
<td>{{$jobHistory->getCompany()}}</td>
<td>{{$jobHistory->getDate()}}</td>
<td>
<td>
<form method = "post" action="doJobHistoryPass">
{{csrf_field()}}<input type="hidden" value="{{$jobHistory->getHistoryID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="active">Edit</button>
</form>
</td>
<td>
<form method="post" action="doDeleteJobHistory">
{{csrf_field()}}<input type="hidden" value="{{$jobHistory->getHistoryID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="delete">Delete</button>
</form>
</td>
<td></td>
</tr>
@endforeach
</tbody>
</table>
<form action="addjh">
	<button type="submit">Add Job History</button>
</form>
</div>
<h4>My Education</h4>
<div>
<table class="table">
<tr>
<td>School</td>
<td>Level</td>
<td>Date</td>
<br/>
<td>EDIT</td>
<td>DELETE</td>
</tr>
<tbody>
@foreach ($EducationArray as $edu)
<tr>
<td>{{$edu->getSchool()}}</td>
<td>{{$edu->getLevel()}}</td>
<td>{{$edu->getDate()}}</td>
<td>
<td>
<form method = "post" action="doEducationPass">
{{csrf_field()}}<input type="hidden" value="{{$edu->getEducationID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="active">Edit</button>
</form>
</td>
<td>
<form method="post" action="doDeleteEducation">
{{csrf_field()}}<input type="hidden" value="{{$edu->getEducationID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="delete">Delete</button>
</form>
</td>
<td></td>
</tr>
@endforeach
</tbody>
</table>
<form action="addedu">
{{csrf_field()}}<input type="hidden" value="{{Session::get('UserID')}}" name="id"></input>
	<button type="submit">Add Education</button>
</form>
</div>
<h4>My Skills</h4>
<div>
<table class="table">
<tr>
<td>Title</td>
<td>Description</td>
<br/>
<td>EDIT</td>
<td>DELETE</td>
</tr>
<tbody>
@foreach ($SkillsArray as $skill)
<tr>
<td>{{$skill->getTitle()}}</td>
<td>{{$skill->getDescription()}}</td>
<td>
<td>
<form method = "post" action="doSkillPass">
{{csrf_field()}}<input type="hidden" value="{{$skill->getSkillID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="active">Edit</button>
</form>
</td>
<td>
<form method="post" action="doDeleteSkill">
{{csrf_field()}}<input type="hidden" value="{{$skill->getSkillID()}}" name="id"></input>
<button class="btn btn-primary" type="submit" value="delete">Delete</button>
</form>
</td>
<td></td>
</tr>
@endforeach
</tbody>
</table>
<form action="addskill">
{{csrf_field()}}<input type="hidden" value="{{Session::get('UserID')}}" name="id"></input>
	<button type="submit">Add Skill</button>
</form>
</div>
@endsection