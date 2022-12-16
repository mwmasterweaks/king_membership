<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_references', function (Blueprint $table) {
            $table->integer('member_id');
            $table->string('ref1_name')->nullable();
            $table->string('ref1_address')->nullable();
            $table->string('ref1_contact')->nullable();
            $table->string('ref2_name')->nullable();
            $table->string('ref2_address')->nullable();
            $table->string('ref2_contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_references');
    }
}
