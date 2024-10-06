@extends('layouts.my-layout')

@section('title', 'Voting edit')

@section('content')
<h2 class="display-3">Edit the Info</h2>
<form method="post" action="{{ route('voting.update', ['prevVoting' => $model]) }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 fs-3">
        @include("voting._form_fields", ['model' => $model])
    </div>
    <button type="submit" class="btn btn-outline-success my-3 fs-3">Submit</button>
</form>
@endsection