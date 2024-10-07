<?php

namespace App\Http\Controllers;

use App\Http\Services\UploadFileService;
use App\Models\Image;
use App\Models\Info;
use App\Models\User;
use App\Models\Voting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class VotingController extends Controller
{
    public function index(): View
    {
        return view("voting.index",['models'=>Voting::all()]);
    }
    public function create(): View
    {
        return view("voting.create");
    }
    public function store(FormRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|max:50|min:3',
            'start_at' => 'required|after_or_equal:today',
            'end_at' => 'required|after:start_at',
        ]);

        $model = new Voting();
        $model->fill($data);

        $model->save();

        return to_route('voting.index');
    }
    public function edit(Voting $voting): View
    {
        return view("voting.edit", ["model" => $voting]);
    }

    public function update(Voting $prevVoting, FormRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|max:50|min:3',
            'start_at' => 'required|after_or_equal:today',
            'end_at' => 'required|after:start_at',
        ]);

        $prevVoting->fill($data);

        $prevVoting->update();

        return to_route('voting.index');
    }

    public function delete(Voting $voting)
    {
        foreach ($voting->candidates as $candidate) {
            if($candidate->image!=null) $candidate->image->delete();
            $candidate->delete();
        }
        $voting->delete();
        return to_route('voting.index');
    }
    public function candidates(Voting $voting){
        return view("voting.candidates_modal", ["model" => $voting]);
    }

}
