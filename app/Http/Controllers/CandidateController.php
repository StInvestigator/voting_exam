<?php

namespace App\Http\Controllers;

use App\Http\Services\UploadFileService;
use App\Models\Candidate;
use App\Models\Image;
use App\Models\Info;
use App\Models\Voting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class CandidateController extends Controller
{
    public function add(Voting $voting): View
    {
        return view("candidate.add", ["model" => $voting]);
    }
    public function store(Voting $voting, FormRequest $request, UploadFileService $service)
    {
        $data = $request->validate([
            'image' => 'image|max:2048',
            'first_name' => 'required|max:50|min:3',
            'last_name' => 'required|max:50|min:3',
        ]);
        $model = new Candidate();
        $model->fill($data);

        if (request()->hasFile('image')) {
            $service->setImage($request->file('image'), $model, 'candidates');
        }

        $voting->candidates()->save($model);

        return to_route('voting.index');
    }
    public function edit(Candidate $candidate): View
    {
        return view("candidate.edit", ["model" => $candidate]);
    }

    public function update(Candidate $prevCandidate, FormRequest $request, UploadFileService $service)
    {
        $data = $request->validate([
            'image' => 'image|max:2048',
            'first_name' => 'required|max:50|min:3',
            'last_name' => 'required|max:50|min:3',
        ]);

        $prevCandidate->fill($data);

        if (request()->hasFile('image')) {
            $service->setImage($request->file('image'), $prevCandidate, 'candidates');
        }

        $prevCandidate->update();

        return to_route('voting.index');
    }

    public function delete(Candidate $candidate)
    {
        if ($candidate->image != null)
            $candidate->image->delete();
        $candidate->delete();

        return to_route('voting.index');
    }

}
