<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->longText('note');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'declined'));
			$table->integer('restaurant_id')->unsigned()->nullable();
			$table->integer('client_id')->unsigned()->nullable();
			$table->decimal('price')->default(0);
			$table->decimal('delivery')->default(0);
			$table->decimal('commission')->default(0);
			$table->decimal('total')->default(0);
			$table->string('address');
			$table->integer('payment_method_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}