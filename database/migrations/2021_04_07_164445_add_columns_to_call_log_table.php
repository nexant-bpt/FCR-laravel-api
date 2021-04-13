<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCallLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_logs', function (Blueprint $table) {
            //
            $table->dateTime('CLCreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('ClientID')->nullable();
            $table->foreignId('CustomerID')->nullable();
            $table->foreignId('UserID')->nullable();
            $table->foreignId('ProgramID')->nullable();
            $table->char('CLInOut', 1)->nullable();
            $table->string('CLPromoCode', 50)->nullable();
            $table->string('CLDiscountCode', 50)->nullable();
            $table->string('CLPhone', 15)->nullable();
            $table->string('CLEmail', 100)->nullable();
            $table->string('CLReasonCall', 6)->nullable();
            $table->string('CLAction', 6)->nullable();
            $table->string('CLTransferTo', 6)->nullable();
            $table->string('CLSource', 6)->nullable();
            $table->string('CLAppointment', 500)->nullable();
            $table->smallInteger('CLStatus')->nullable();
            $table->string('CLConversion', 6)->nullable();
            $table->string('CLResBus', 6)->nullable();
            $table->dateTime('CLUpdateDate')->nullable();
            $table->string('CLCallOrigin', 6)->nullable();
            $table->string('CLCallerType', 6)->nullable();
            $table->smallInteger('FirstCallRes')->nullable();
            $table->string('CLCustDisposition', 6)->nullable();
            $table->string('CLRegStatus', 6)->nullable();
            $table->dateTime('CLDateEscalation')->nullable();
            $table->dateTime('CLDateResolution')->nullable();
            $table->string('CLCallerName', 200)->nullable();
            $table->text('CLCallNote2')->nullable();
            $table->string('CLAttribute01', 20)->nullable();
            $table->string('CLAttribute02', 20)->nullable();
            $table->string('CLAttribute03', 20)->nullable();
            $table->string('CLAttribute04', 20)->nullable();
            $table->string('CLAttribute05', 20)->nullable();
            $table->string('CLInterpreter', 20)->nullable();
            $table->text('CLNote3')->nullable();
            $table->char('CLFlag', 1)->nullable();
            $table->foreignId('F9CallLogID')->nullable();
            $table->string('CustomerDisposition', 255)->nullable();
            $table->integer('ARCAWaitlist')->nullable();
            $table->string('BusinessOrResidential', 44)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_logs', function (Blueprint $table) {
            //
        });
    }
}
