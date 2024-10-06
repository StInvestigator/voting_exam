@php
    /**
     * @var \App\Models\Voting $model
     */
@endphp

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Candidates in "{{$model->name}}"</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @if($model->candidates->count() == 0)
            <h3 class="text-center">Currently there is no candidates</h3>
        @endif
        @foreach ($model->candidates as $candidate)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="d-flex" style="justify-content:space-between;">
                            <div class="mx-2">
                                <img style="width:130px; height:120px; border-radius:100%; margin:10px auto 0"
                                    src="{{$candidate->image ? $candidate->image->src : Storage::disk("candidates")->url('guest.jpg')}}" />
                                <h5 class="card-title d-flex" style="font-size:24px">
                                    {{$candidate->first_name . ' ' . $candidate->last_name}}
                                </h5>
                            </div>
                            <div class="d-flex mx-2">
                                @if(Auth::user()->role == "Admin")
                                    <a href="{{route('candidate.edit', ['candidate' => $candidate])}}"
                                        class="btn btn-outline-primary fs-5 my-auto mx-3 px-4 w-100" style="height:50px">Edit</a>
                                    <a href="{{route('candidate.delete', ['candidate' => $candidate])}}"
                                        class="btn btn-outline-danger fs-5 my-auto px-4" style="height:50px">Remove</a>
                                @elseif(Auth::user()->role == "User")
                                    <div>
                                        <h3 class="d-block">{{$candidate->votesCount}} vote(s)
                                            [{{$model->totalVotesCount != 0 ? round((double) $candidate->votesCount / $model->totalVotesCount * 100, 1) : 0}}%]
                                        </h3>
                                        @if($model->currentStatus == "Ongoing")
                                            <button data-voting-id="{{$model->id}}" data-candidate-id="{{$candidate->id}}"
                                                class="btn btn-outline-success fs-5 mx-auto my-3 px-4 vote" style="height:50px"
                                                data-success-message="Your vote has been received!"
                                                data-error-message="Something went wrong...">Give a
                                                vote</button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

    <div class="modal-footer">
        @if(Auth::user()->role == "Admin")
            <div class="d-flex justify-content-between w-100">
                <a class="btn btn-outline-success w-25 text-center"
                    href="{{route('candidate.add', ['voting' => $model])}}">Add</a>
                <button type="button" class="btn btn-outline-primary w-25" data-bs-dismiss="modal">Close</button>
            </div>
        @else
            <button type="button" class="btn btn-outline-primary w-25" data-bs-dismiss="modal">Close</button>
        @endif
    </div>
</div>