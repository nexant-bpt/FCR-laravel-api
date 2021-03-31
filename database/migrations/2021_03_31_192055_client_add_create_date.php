<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ClientAddCreateDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    

        Schema::create('clients', function (Blueprint $table) {
            $table->id("ClientId");
            $table->timestamps();
            $table->string("Name")->default("Client Name");
            $table->string("GreetingInitial")->default("Hello");
            $table->string("Icon")->nullable();
            $table->string("Logo")->nullable();
            $table->string("Header")->nullable();
            $table->string("Website")->nullable();
            $table->dateTime('CreateDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer("ClientStatus")->default(0);
            $table->bigInteger("F9ClientID");
            $table->string("CallClosing")->nullable();
            $table->string("CustomerInfoOpening")->nullable();
            $table->string("CallBackScript")->nullable();
            $table->string("SourceScript")->nullable();
            $table->string("TopPrograms")->nullable();
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
