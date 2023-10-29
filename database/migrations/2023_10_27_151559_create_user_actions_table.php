<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_actions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('action_id');
            $table->comment('Участие пользователя в акции');

            $table->primary(['user_id', 'action_id']);


            $table->foreign('user_id')->references('id')->on('users')->restrictOnUpdate()->restrictOnDelete();
            $table->foreign('action_id')->references('id')->on('actions')->restrictOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_actions', function (Blueprint $table) {
            $table->dropForeign('user_actions_action_id_foreign');
            $table->dropForeign('user_actions_user_id_foreign');
        });

        Schema::dropIfExists('user_actions');
    }
};
