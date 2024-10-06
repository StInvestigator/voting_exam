@extends('layouts.my-layout')

@section('title', 'Candidate create')

@section('content')
<h2 class="display-3">Add a candidate</h2>
<form method="post" action="{{ route('candidate.store',['voting'=>$model]) }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 fs-3">
        @include("candidate._form_fields")
    </div>
    <button type="submit" class="btn btn-outline-success my-3 fs-3">Submit</button>
</form>
@endsection