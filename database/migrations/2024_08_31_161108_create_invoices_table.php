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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('invoices_number',100);
            $table->date('invoices_date');
            $table->date('due_date');
            $table->string('product');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->decimal('amount_collection',8,2)->nullable();
            $table->decimal('amount_comission',8,2);
            $table->decimal('discount');
            $table->string('rate_vate');
            $table->decimal('value_vat',8,3);
            $table->decimal('total',8,3);
            $table->string('status',60);
            $table->integer('status_value');
            $table->string('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
