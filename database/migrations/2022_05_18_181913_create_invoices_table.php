<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
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
            $table->string('invoice_no')->nullable();
            $table->bigInteger('standard_id')->unsigned()->nullable();
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->longText('order_items')->nullable();
            $table->string('billing_name')->nullable();
            $table->decimal('amount_total', 10, 2)->default(0.00);
            $table->boolean('payment_status')->default(0)->comment("0=Cash, 1=Pending");
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
}
