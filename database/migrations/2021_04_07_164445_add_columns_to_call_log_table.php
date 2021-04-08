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
        Schema::table('call_log', function (Blueprint $table) {
            //
            $table->dateTime('CLCreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('ClientID')->nullable();
            $table->foreignId('CustomerID')->nullable();
            $table->foreignId('UserID')->nullable();
            $table->foreignId('ProgramID')->nullable();
            $table->char('CLInOut', 1)->nullable();
            $table->varchar('CLPromoCode', 50)->nullable();
            $table->varchar('CLDiscountCode', 50)->nullable();
            $table->varchar('CLPhone', 15)->nullable();
            $table->varchar('CLEmail', 100)->nullable();
            $table->varchar('CLReasonCall', 6)->nullable();
            $table->varchar('CLAction', 6)->nullable();
            $table->varchar('CLTransferTo', 6)->nullable();
            $table->varchar('CLSource', 6)->nullable();
            $table->varchar('CLAppointment', 500)->nullable();
            $table->bit('CLStatus', 1)->nullable();
            $table->varchar('CLConversion', 6)->nullable();
            $table->varchar('CLResBus', 6)->nullable();
            $table->dateTime('CLUpdateDate')->nullable();
            $table->varchar('CLCallOrigin', 6)->nullable();
            $table->varchar('CLCallerType', 6)->nullable();
            $table->bit(1)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_log', function (Blueprint $table) {
            //
        });
    }
}
