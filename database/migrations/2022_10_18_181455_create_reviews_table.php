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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')
            ->on('users')
                ->onDelete('Set null')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('lawyer_id')
            ->on('users')
                ->onDelete('Set null')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('reservation_id')
                ->on('reservations')
                ->onDelete('Set null')
                ->onUpdate('cascade');
            $table->double('review')->nullable();
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
        Schema::dropIfExists('reviews');
    }
};
