<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfinementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confinements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->comment('被禁言用户id');
            $table->boolean('is_permanent')->default(false)->comment('是否永久禁言');
            $table->integer('confined_by')->unsigned()->comment('被谁禁言');
            $table->timestamp('confined_at')->nullable()->comment('禁言开始时间');
            $table->timestamp('expired_at')->nullable()->comment('禁言结束时间');
            $table->boolean('is_abolished')->default(false)->comment('是否提前终止');
            $table->integer('abolished_by')->unsigned()->nullable()->comment('被谁提前终止');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confinements');
    }
}
