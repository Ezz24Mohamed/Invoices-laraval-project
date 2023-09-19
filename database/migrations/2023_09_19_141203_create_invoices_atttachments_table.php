<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_atttachments', function (Blueprint $table) {
            $table->id();
            $table ->string('file_name',800);
            $table->string('invoice_num');
            $table->string('user',800);
            $table->unsignedBigInteger('inv_id')->nullable();
            $table->foreign('inv_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('invoices_atttachments');
    }
};
