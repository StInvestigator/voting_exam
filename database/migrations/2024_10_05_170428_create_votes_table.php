<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('voting_id');
            $table->unsignedBigInteger('candidate_id');
            $table->timestamps();

            $table->foreign('user_id','FK_votes_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('voting_id',"FK_votes_voting_id")->references('id')->on('votings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('candidate_id','FK_votes_candidate_id')->references('id')->on('candidates')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropForeign('FK_votes_user_id');
            $table->dropForeign('FK_votes_voting_id');
            $table->dropForeign('FK_votes_candidate_id');
        });
        Schema::dropIfExists('votes');
    }
};
