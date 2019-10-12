<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->longText('description');
			$table->decimal('price');
			$table->decimal('offer')->nullable();
			$table->string('time');
			$table->string('image');
			$table->integer('restaurant_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}