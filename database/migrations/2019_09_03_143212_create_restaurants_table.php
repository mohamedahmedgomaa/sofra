<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email')->unique();
			$table->integer('phone');
			$table->string('password');
			$table->decimal('minimum');
			$table->decimal('delivery');
			$table->string('image');
			$table->integer('neighborhood_id')->unsigned()->nullable();
			$table->enum('state', array('open', 'close'));
			$table->string('api_token', 60)->unique()->nullable();
			$table->integer('whats_app');
			$table->integer('restaurant_phone');
			$table->integer('pin_code')->nullable();
            $table->boolean('activated')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}