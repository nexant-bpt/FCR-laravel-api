<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NewCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->id("CustomerId");
            $table->timestamps();
            $table->foreignId('ClientID')->nullable();
            $table->string('AccountNumber', 50)->nullable();
            $table->string('CustomerNumber', 40)->nullable();
            $table->string('FirstName', 50)->nullable();
            $table->string('LastName', 50)->nullable();
            $table->string('CompressedName', 200)->nullable();
            $table->string('Address1', 100)->nullable();
            $table->string('Address2', 100)->nullable();
            $table->string('City', 50)->nullable();
            $table->char('State', 2)->nullable();
            $table->string('Zip')->nullable();
            $table->string('Phone1')->nullable();
            $table->string('Phone2')->nullable();
            $table->string('EmailAddress')->nullable();
            $table->char('RateCode', 3)->nullable();
            $table->char('CreateManual', 1)->nullable();
            $table->dateTime('CreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer("CustomerStatus")->default(0);
            $table->string('PremiseNo')->nullable();
            $table->string('County')->nullable();
            $table->string('MailAddress', 1000)->nullable();
            $table->date('ConsentDatePremisePhone')->nullable();
            $table->date('ConsentDateCustomerPhone')->nullable();
            $table->float('ArrearsAmt')->nullable();
            $table->float('CurrentBalance')->nullable();
            $table->float('AverageBill')->nullable();
            $table->integer('DaysInArrears')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
