<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('institution_id')->nullable();
            $table->unsignedInteger('transaction_status_id')->nullable();
            $table->string('in_out')->nullable();
            $table->string('officer');
            $table->string('amount')->nullable();
            $table->string('noted')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('cascade')->onDelete('no action');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');
            $table->foreign('institution_id')->references('id')->on('institutions')
                ->onUpdate('cascade')->onDelete('no action');
            $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses')
                ->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
