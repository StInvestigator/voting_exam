@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    /**
     * @var \App\Models\Voting[] $models
     */
@endphp


@extends('layouts.my-layout')

@section('title', 'Voting page')

@section('content')

<!-- Modal -->

<div class="modal fade" id="candidates-form-modal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    </div>
</div>

<!-- Votings list -->

<div class="d-flex justify-content-between">
    <h2 class="display-3">Current votings</h2>
    @if(Auth::user()->role == "Admin")
        <a class="btn btn-outline-primary fs-5 d-flex my-auto px-5" href="{{route('voting.create')}}">Create</a>
    @endif
</div>
<table class="table">
    <thead>
        <tr scope="row">
            <th scope="col">#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Starting date</th>
            <th>Ending date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($models as $model)

            <tr scope="row">
                <th scope="col">{{$model->id}}</th>
                <td>{{$model->name}}</td>
                <td>
                    <div style="padding: 12px 0"
                        class="mt-1 badge bg-{{$model->currentStatus == "Ended" ? "danger" : ($model->currentStatus == "Ongoing" ? "success" : "warning text-dark")}} m-0 d-block w-100">
                        {{$model->currentStatus}}
                    </div>
                </td>
                <td>{{$model->start_at}}</td>
                <td>{{$model->end_at}}</td>

                <td>
                    @if(Auth::user()->role == "Admin")
                        <button class="btn btn-outline-success fs-5 show-candidates" style="width: 40%;"
                            data-id="{{$model->id}}">Candidates</button>
                        <a class="btn btn-outline-warning fs-5 w-25"
                            href="{{route('voting.edit', ['voting' => $model])}}">Edit</a>
                        <a class="btn btn-outline-danger fs-5 w-25"
                            href="{{route('voting.delete', ['voting' => $model])}}">Delete</a>
                    @elseif(Auth::user()->role == "User")
                        @if(Auth::user()->attendedVotings->contains($model) && $model->currentStatus == "Ongoing")
                            <div class="mt-1 badge bg-success m-0 d-block" style="width:80%; padding:12px 0">Attended</div>
                        @else
                            <button
                                class="btn btn-outline-{{$model->currentStatus == "Ended" ? "danger" : "success"}} fs-5 show-candidates"
                                style="width: 80%;"
                                data-id="{{$model->id}}">{{$model->currentStatus == "Ended" ? "Results" : "Candidates"}}</button>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section("scripts")
<script>
    var myModal = new bootstrap.Modal(document.getElementById('candidates-form-modal'), {
        keyboard: false
    })

    $('button.show-candidates')
        .on('click', e => {
            let id = $(e.target).data('id')
            fetch(`/voting/candidates/${id}`).then(r => r.text()).then(html => {
                $('.modal-dialog').html(html)
                myModal.show()
            }).then(() => {
                $('button.vote').on('click', e => {
                    const target = $(e.target)
                    let voting_id = target.data('voting-id')
                    let candidate_id = target.data('candidate-id')
                    let success = target.data("success-message")
                    let error = target.data("error-message")

                    $.ajax({
                        type: "POST",
                        url: `/api/v1/vote/${voting_id}/${candidate_id}/{{Auth::id()}}`,
                        contentType: 'application/json',
                        success: function (response) {
                            console.log(response)
                            myModal.hide()

                            Swal.fire(success, "", "success").then(() => {
                                window.location.reload()
                            });
                        },
                        error: function (response) {
                            console.log(response)
                            Swal.fire(error, "", "error")
                        }
                    })
                })
                $('button.candidate-remove').on('click', e => {
                    const target = $(e.target)
                    let id = target.data('id')
                    let success = target.data("success-message")
                    let error = target.data("error-message")

                    $.ajax({
                        type: "POST",
                        url: `/api/v1/candidate/remove/${id}`,
                        contentType: 'application/json',
                        success: function (response) {
                            console.log(response)
                            myModal.hide()

                            Swal.fire(success, "", "success").then(() => {
                                window.location.reload()
                            });
                        },
                        error: function (response) {
                            console.log(response)
                            Swal.fire(respo, "", "error")
                        }
                    })
                })
            })
        })
</script>
@endsection