<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('acc_no')->nullable();
            $table->string('title')->nullable();
            $table->string('nickname')->nullable();
            $table->string('first_name');
            $table->string('mid_name')->nullable();
            $table->string('last_name');
            $table->string('prev_last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('resident')->nullable();
            $table->string('resident_citizenship')->nullable();

            $table->integer('age');
            $table->string('gender');
            $table->string('contact_no');
            $table->date('contact_last_update')->nullable();
            $table->string('contact2_no')->nullable();
            $table->date('contact2_last_update')->nullable();
            $table->date('birthdate');
            $table->string('nationality');
            $table->string('birthcountry');
            $table->string('birthplace');
            $table->string('civil_stat');
            $table->integer('branch_id');

            $table->string('present_residential');
            $table->string('monthly_present')->nullable();
             $table->date('occupied_present');
            $table->date('last_update_present')->nullable();
            $table->string('permanent_address');
            $table->string('monthly_permanent')->nullable();
            $table->date('last_update_permanent')->nullable();
            $table->date('occupied_permanent');

            $table->string('image')->nullable();
            $table->string('image_id_1')->nullable();
            $table->string('image_id_2')->nullable();
            $table->string('image_sketch')->nullable();

            $table->string('application_status')->default('Pending');
            $table->string('membership_status');
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
        Schema::dropIfExists('members');
    }
}
