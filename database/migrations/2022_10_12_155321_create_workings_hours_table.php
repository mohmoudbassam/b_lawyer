<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->text('day')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->foreignId('lawyer_id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('set Null')
                ->nullable();
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
        Schema::dropIfExists('workings_hours');
    }
};
