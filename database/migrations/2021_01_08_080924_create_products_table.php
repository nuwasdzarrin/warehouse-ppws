<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institution_id')->nullable();
            $table->unsignedInteger('product_category_id')->nullable();
            $table->string('name');
            $table->bigInteger('stock')->nullable();
            $table->string('noted')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institutions')
                ->onUpdate('cascade')->onDelete('no action');
            $table->foreign('product_category_id')->references('id')->on('product_categories')
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
        Schema::dropIfExists('products');
    }
}
