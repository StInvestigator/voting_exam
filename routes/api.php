<?php

use App\Http\Controllers\Api\CandidateController;
use App\Http\Controllers\Api\VotingController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    Route::post("/vote/{voting_id}/{candidate_id}/{user_id}",[VotingController::class,"vote"]);
    Route::post("/candidate/remove/{candidate}",[CandidateController::class,"remove"]);
});