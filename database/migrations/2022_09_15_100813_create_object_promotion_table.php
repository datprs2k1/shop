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
        Schema::create('object_promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('object_id');
            $table->string('object_type');
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_promotion');
    }
};
