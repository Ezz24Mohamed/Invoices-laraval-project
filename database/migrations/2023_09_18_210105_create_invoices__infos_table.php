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
        Schema::create('invoices__infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inv_id');
            $table->foreign('inv_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('invoice_num');
            $table->string('invoice_status');
            $table->integer('bool_status');
            $table->string('section');
            $table->string('product');
            $table->string('user');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('invoices__infos');
    }
};
