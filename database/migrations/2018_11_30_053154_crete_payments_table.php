<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CretePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id');
            $table->string('mode_of_payment');
            $table->float('bill_amount', 8, 2);            
            $table->integer('cheque_no')->nullable();
            $table->date('cheque_issue_date')->nullable();
            $table->date('cheque_withdrawl_date')->nullable();
            $table->string('payment_proof_image')->nullable();        
            $table->text('notes')->nullable();   
            $table->string('payment_status');
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
        Schema::dropIfExists('payments');
    }
}
