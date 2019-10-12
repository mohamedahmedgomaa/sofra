<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('phone')->nullable();
			$table->string('email')->nullable();
			$table->longText('text')->nullable();
			$table->longText('contents')->nullable();
			$table->string('image')->nullable();
			$table->string('whats_app')->nullable();
			$table->string('instagram')->nullable();
			$table->string('you_tube')->nullable();
			$table->string('twitter')->nullable();
			$table->string('facebook')->nullable();
			$table->decimal('max_credit');
			$table->decimal('commission')->default(0);
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}