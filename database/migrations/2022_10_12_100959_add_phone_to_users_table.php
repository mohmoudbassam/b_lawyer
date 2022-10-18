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
        Schema::table('users', function (Blueprint $table) {
            $table->text('phone')->nullable();
            $table->text('image')->nullable();
            $table->text('address')->nullable();
            $table->text('about_me')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->integer('enabled')->nullable();
            $table->foreignId('city_id')
                ->on('cities')
                ->onUpdate('CASCADE')
                ->onDelete('set Null')
                ->nullable();
            $table->text('lat')->nullable();
            $table->text('long')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->date('enabled_to')->nullable();
            $table->unsignedBigInteger('lawyer_type')
                ->on('lawyer_types')
                ->onUpdate('CASCADE')
                ->onDelete('set Null')
                ->nullable();

            $table->enum('type', ['lawyer', 'user', 'office'])->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
