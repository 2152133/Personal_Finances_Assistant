@extends('layouts.app')
@section('content')
<div class="jumbotron">
    <h1>{{ $pagetitle }}</h1>
 </div>
<div><a class="btn btn-primary">Add user</a></div>
<table class="table table-striped">
<thead> 
	<tr> 
		<th>Name</th>
		<th>Email</th>
		<th>Type</th> 
		<th>Status</th> 
	</tr> 
</thead>
<tbody>
@foreach ($users as $user)
	<tr>
		<td>{{ $user->name }} </td>
		<td>{{ $user->email }} </td>
		<td>{{ $user->type() }} </td>
		<td>
			@if ($user->blocked === 1)
	          <input type="checkbox" name="status" checked="">
	       	@else
	          <input type="checkbox" name="play" {{ old('status') ? 'checked' : '' }}>
	       	@endif
			{{ $user->status() }}
		</td>
	</tr>
@endforeach
</tbody>
</table>
@endsection('content')