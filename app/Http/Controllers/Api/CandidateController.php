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

class CandidateController extends Controller
{
    private Responder $responder;
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }
    public function remove(Candidate $candidate): JsonResponse
    {
        try {
            if($candidate->image){
                $candidate->image->delete();
            }
            $candidate->delete();
        } catch (Exception $exception) {
            return $this->responder->error($exception->getMessage())->respond();
        }
        return $this->responder->success()->respond();
    }
}
