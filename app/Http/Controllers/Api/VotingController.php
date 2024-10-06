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
    public function vote(int $voting_id, int $candidate_id, int $user_id): JsonResponse
    {
        try {
            $vote = new Vote(['voting_id' => $voting_id, 'user_id' => $user_id, 'candidate_id' => $candidate_id]);
            $vote->save();
        } catch (Exception $exception) {
            return $this->responder->error($exception->getMessage())->respond();
        }
        return $this->responder->success()->respond();
    }
}
