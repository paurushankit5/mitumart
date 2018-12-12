<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CretaeSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_to_display');
            $table->string('vat_no')->nullable();
            $table->string('cst_no')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->boolean('is_preferred_supplier')->default(0);
            $table->boolean('payment_terms')->nullable();
            $table->string('adl1')->nullable();
            $table->string('adl2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
