<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->enum('evaluate', array('1', '2', '3', '4', '5'));
			$table->longText('comment');
			$table->integer('client_id')->unsigned()->nullable();
			$table->integer('restaurant_id')->unsigned()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('comments');
	}
}