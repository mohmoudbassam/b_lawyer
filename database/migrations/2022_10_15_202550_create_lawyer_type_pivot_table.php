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
        Schema::create('lawyer_office_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lawyer_id')
                ->references('id')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE')
                ->on('users');
            $table->unsignedBigInteger('type_id')
                ->references('id')
                ->on('lawyer_types')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
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
        Schema::dropIfExists('lawyer_type_pivote');
    }
};
