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

            $table->text('tiktok')->nullable();
            $table->text('whats_up')->nullable();
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
            $table->text('identity_image')->nullable();
            $table->text('license_number')->nullable();
            $table->text('license_image')->nullable();
            $table->date('enabled_to')->nullable();
            $table->date('identity_number')->nullable();
            $table->text('certificates')->nullable();
            $table->text('experience')->nullable();
            $table->text('majors')->nullable();
            $table->text('union_bound')->nullable();
            $table->unsignedBigInteger('experience_id')
                ->on('experience')
                ->onUpdate('CASCADE')
                ->onDelete('set Null')
                ->nullable();
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
