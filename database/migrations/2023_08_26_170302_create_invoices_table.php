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
            $table->id();
            $table->string('invoice_no');
            $table->dateTime('invoice_date',$precision=0);
            $table->date('due_date');
            $table->string('product');
            $table->string('section');
            $table->decimal('discount',$precision=8,$scale=5);
            $table->decimal('total',$precision=9,$scale=6);
            $table->decimal('value_vat');
            $table->string('rate_vat');
            $table->string('status');
            $table->integer('status_of_value');
            $table->text('note');
            $table->string('user');
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
