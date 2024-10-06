@php /**
     * @var \App\Models\Candidate $model
 */@endphp
 
<label for="first_name " class="form-label">First name</label>
<input name="first_name" class="form-control my-2 fs-4 @error('first_name')
is-invalid @enderror" value="{{ old('first_name') ?? $model->first_name ?? '' }}">
@error('first_name')
    <div class="alert alert-danger p-2">{{ $message }}</div>
@enderror

<label for="last_name " class="form-label">Last name</label>
<input name="last_name" class="form-control my-2 fs-4 @error('last_name')
is-invalid @enderror" value="{{ old('last_name') ?? $model->last_name ?? '' }}">
@error('last_name')
    <div class="alert alert-danger p-2">{{ $message }}</div>
@enderror

<label for="image" class="form-label">Photo</label>
<input name="image" class="form-control" type="file" accept="image/*"
    value="{{old(key: 'image') ?? $model->image ?? null}}">
@error('image')
    <div class="alert alert-danger p-2">{{ $message }}</div>
@enderror