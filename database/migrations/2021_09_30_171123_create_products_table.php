<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->double('price');
            $table->timestamps();
        });

        DB::table('products')
        ->insert([
            ['name' => 'Producto 1', 'price' => 25],
            ['name' => 'Producto 2', 'price' => 50],
            ['name' => 'Producto 3', 'price' => 75],
            ['name' => 'Producto 4', 'price' => 100],
        ]);
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
