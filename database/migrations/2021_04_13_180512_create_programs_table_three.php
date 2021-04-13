<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTableThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        {
            Schema::dropIfExists('programs');

            Schema::create('programs', function (Blueprint $table) {
                $table->id("ProgramID");
                $table->foreignId('ClientId');
                $table->string("Name")->nullable();
                $table->string("Type")->nullable();
                $table->string("ContactName")->nullable();
                $table->string("Links")->nullable();
                $table->string("TransferType")->nullable();
                $table->string("TransferPhone")->nullable();
                $table->string("CallScript")->nullable();
                $table->string("Description")->nullable();
                $table->integer("Status")->default(0);
                $table->dateTime('CreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->string("TransferInstruction")->nullable();
                $table->string("Summary")->nullable();
                $table->string("KeyWords")->nullable();
                $table->string("AssociatedStates")->nullable();
                $table->string("AssociatedActions")->nullable();
                $table->integer("IsTransfer")->default(0);
                $table->integer("F9Code")->default(0);
                $table->string("CrossPromotion")->default(0);
                $table->timestamps();

            });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
