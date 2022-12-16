<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_details', function (Blueprint $table) {
            $table->integer('member_id');
            $table->integer('dependents_no')->nullable();
            $table->integer('children_no')->nullable();
            $table->integer('household_no')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_age')->nullable();
            $table->string('spouse_occupation')->nullable();
            $table->string('spouse_employer')->nullable();
            $table->string('spouse_address')->nullable();
            $table->string('mother_first_name')->nullable();
            $table->string('mother_mid_name')->nullable();
            $table->string('mother_last_name')->nullable();
            $table->string('mother_suffix')->nullable();
            $table->string('father_first_name')->nullable();
            $table->string('father_mid_name')->nullable();
            $table->string('father_last_name')->nullable();
            $table->string('father_suffix')->nullable();

            $table->integer('owned_properties')->nullable();
            $table->integer('owned_cars')->nullable();
            $table->string('ownership_present')->nullable();
            $table->string('ownership_permanent')->nullable();

            $table->string('income_source')->nullable();
            $table->string('income_via')->nullable();
            $table->string('other_income_via')->nullable();
            $table->string('emp_employer')->nullable();
            $table->string('emp_nature')->nullable();
            $table->string('emp_tin')->nullable();
            $table->integer('emp_tel_no')->nullable();
            $table->string('emp_address')->nullable();
            $table->string('emp_position')->nullable();
            $table->string('emp_date_employed')->nullable();
            $table->string('emp_gross')->nullable();
            $table->string('emp_currency')->nullable();
            $table->string('emp_annual')->nullable();
            $table->string('emp_occ_status')->nullable();
            $table->string('bn_name')->nullable();
            $table->string('bn_nature')->nullable();
            $table->date('bn_established')->nullable();
            $table->string('bn_tin')->nullable();
            $table->string('bn_address')->nullable();
            $table->integer('bn_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_details');
    }
}
