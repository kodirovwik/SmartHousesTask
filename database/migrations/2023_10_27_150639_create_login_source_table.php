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
        Schema::create('login_source', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('tms');
            $table->enum('source', ['site', 'android', 'iphone'])->default('site');
            $table->comment('История авторизаций');

            $table->foreign('user_id')->references('id')->on('users')->restrictOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_source', function (Blueprint $table) {
            $table->dropForeign('login_source_user_id_foreign');
        });

        Schema::dropIfExists('login_source');
    }
};
