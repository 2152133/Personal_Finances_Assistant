@extends('layouts.app')
@section('content')
<div class="jumbotron">
    <h1>{{ $pagetitle }}</h1>
</div>
@if (session('msgglobal'))
    <div class="alert alert-danger">
        {{ session('msgglobal') }}
    </div>
@endif

<div>
	{!! Form::open(['method'=>'GET','route'=>'users','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

	<div class="input-group custom-search-form">
	    <input type="text" class="form-control" name="name" placeholder="Search...">
	    <input type="text" class="form-control" name="admin" placeholder="Search...">
	    <input type="text" class="form-control" name="blocked" placeholder="Search...">
	    <span class="input-group-btn">
	        <button class="btn btn-default-sm" type="submit">
	            <i class="fa fa-search"><!--<span class="hiddenGrammarError" pre="" data-mce-bogus="1"-->i>
	        </button>
	    </span>
	</div>
	{!! Form::close() !!}
</div>

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
		<td>{{ $user->name }}</td>
		<td>{{ $user->email }}</td>
		<td>{{ $user->type() }}</td>
		<td>{{ $user->status() }}</td>
		<td>
			@if ($user->blocked === 0)
	          	<form action="{{ action('UserController@block', $user->id ) }}" method="post" class="inline">
					@csrf
					@method('patch')
					<input type="submit" class="btn btn-xs btn-danger custom1" value="{{ $user->buttonStatus() }} ">
				</form>
	       	@else
	          	<form action="{{ action('UserController@unblock', $user->id ) }}" method="post" class="inline">
					@csrf
					@method('patch')
					<input type="submit" class="btn btn-xs btn-danger custom1" value="{{ $user->buttonStatus() }} ">
				</form>
	       	@endif
			@if ($user->admin === 0)
	          	<form action="{{ action('UserController@promote', $user->id ) }}" method="post" class="inline">
					@csrf
					@method('patch')
					<input type="submit" class="btn btn-xs btn-primary custom" value="{{ $user->buttonType() }} ">
				</form>
	       	@else
	          	<form action="{{ action('UserController@demote', $user->id ) }}" method="post" class="inline">
					@csrf
					@method('patch')
					<input type="submit" class="btn btn-xs btn-primary custom" value="{{ $user->buttonType() }} ">
				</form>
	       	@endif
			
			
		</td>
	</tr>
@endforeach
</tbody>
</table>
@endsection('content')