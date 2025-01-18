<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_invoices');
            $table->string('invoices_number', 100);
            $table->foreign('id_invoices')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('product', 100);
            $table->string('section', 255);
            $table->string('status', 100);
            $table->integer('status_value');
            $table->date('payment_date')->nullable();
            $table->text('note')->nullable();
            $table->string('user', 255);
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
        Schema::dropIfExists('invoices_details');
    }
};
