<?php

namespace App\Models\Transformers;

use App\Models\Candidate;
use App\Models\Info;
use Flugg\Responder\Transformers\Transformer;

class CandidateTransformer extends Transformer{
    protected $relations = [
        'image' => ImageTransformer::class,
    ];

    public function transform(Candidate $model){
        return [
            "id" => $model->id,
            "first_name" => $model->first_name,
            "last_name" => $model->last_name,
            'votesCount' => $model->votesCount,
        ];
    }
}