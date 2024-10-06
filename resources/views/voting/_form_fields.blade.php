@php /**
     * @var \App\Models\Voting $model
 */@endphp
 
<label for="name " class="form-label">Title</label>
<input name="name" class="form-control my-2 fs-4 @error('name')
is-invalid @enderror" value="{{ old('name') ?? $model->name ?? '' }}">
@error('name')
    <div class="alert alert-danger p-2">{{ $message }}</div>
@enderror

<label for="start_at" class="form-label">Start at</label>
<input name="start_at" class="form-control fs-4 my-2 date @error('start_at')
is-invalid @enderror" type="datetime-local" value="{{ old(key: 'start_at') ?? $model->start_at ?? null }}">
@error('start_at')
    <div class="alert alert-danger p-2">{{ $message }}</div>
@enderror

<label for="end_at" class="form-label">End at</label>
<input name="end_at" class="form-control fs-4 my-2 date @error('end_at')
is-invalid @enderror" type="datetime-local" value="{{ old(key: 'end_at') ?? $model->end_at ?? null }}">
@error('end_at')
    <div class="alert alert-danger p-2">{{ $message }}</div>
@enderror