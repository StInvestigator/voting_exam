<?php

namespace App\Http\Controllers\Api;

use App\Models\Candidate;
use App\Models\Feedback;
use Illuminate\Routing\Controller;
use App\Models\Info;
use App\Models\Transformers\CandidateTransformer;
use App\Models\Transformers\FeedbackTransformer;
use App\Models\Transformers\InfoTransformer;
use App\Models\Vote;
use App\Models\Voting;
use Exception;
use Flugg\Responder\Responder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    private Responder $responder;
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }
    public function vote(Candidate $candidate): JsonResponse
    {
        try {
            if (Vote::whereRaw('user_id = ? and voting_id = ?', [Auth::user()->id, $candidate->voting->id])->get()->count() == 0) {
                $vote = new Vote(['voting_id' => $candidate->voting->id, 'user_id' => Auth::user()->id, 'candidate_id' => $candidate->id]);
                $vote->save();
            }
            else{
                return $this->responder->error("You already attended in this voting!")->respond();
            }
        } catch (Exception $exception) {
            return $this->responder->error($exception->getMessage())->respond();
        }
        return $this->responder->success()->respond();
    }
}
