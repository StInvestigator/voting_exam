@extends('layouts.my-layout')

@section('title', 'Voting create')

@section('content')
<h2 class="display-3">Create the Voting</h2>
<form method="post" action="{{ route('voting.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 fs-3">
        @include("voting._form_fields")
    </div>
    <button type="submit" class="btn btn-outline-success my-3 fs-3">Submit</button>
</form>
@endsection