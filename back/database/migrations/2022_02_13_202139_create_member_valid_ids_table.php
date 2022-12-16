<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberValidIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_valid_ids', function (Blueprint $table) {
            $table->integer('member_id');
            $table->string('sss')->nullable();
            $table->string('gsis')->nullable();
            $table->string('tin')->nullable();
            $table->string('otherID1_type')->nullable();
            $table->string('otherID1_number')->nullable();
            $table->string('otherID1_issued_date')->nullable();
            $table->string('otherID1_expiry_date')->nullable();
            $table->string('otherID1_issue_country')->nullable();
            $table->string('otherID1_issue_by')->nullable();
            $table->string('otherID1_last_update')->nullable();
            $table->string('otherID2_type')->nullable();
            $table->string('otherID2_number')->nullable();
            $table->string('otherID2_issued_date')->nullable();
            $table->string('otherID2_expiry_date')->nullable();
            $table->string('otherID2_issue_country')->nullable();
            $table->string('otherID2_issue_by')->nullable();
            $table->string('otherID2_last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_valid_ids');
    }
}
