<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question__choices', function (Blueprint $table) {
            $table->id();

            $table->integer('question_id');
            $table->string('choice');
            $table->boolean('is_true_choice');

            //作成日と更新日
            $table->timestamps();
            //論理削除カラムの追加
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question__choices');
    }
}
