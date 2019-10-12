<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('restaurants', function(Blueprint $table) {
			$table->foreign('neighborhood_id')->references('id')->on('neighborhoods')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('clients', function(Blueprint $table) {
			$table->foreign('neighborhood_id')->references('id')->on('neighborhoods')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('neighborhoods', function(Blueprint $table) {
			$table->foreign('city_id')->references('id')->on('cities')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('payment_method_id')->references('id')->on('payment_methods')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('payments', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')
						->onDelete('set null')
						->onUpdate('set null');
		});
	}

	public function down()
	{
		Schema::table('restaurants', function(Blueprint $table) {
			$table->dropForeign('restaurants_neighborhood_id_foreign');
		});
		Schema::table('clients', function(Blueprint $table) {
			$table->dropForeign('clients_neighborhood_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_restaurant_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_client_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_restaurant_id_foreign');
		});
		Schema::table('neighborhoods', function(Blueprint $table) {
			$table->dropForeign('neighborhoods_city_id_foreign');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->dropForeign('offers_restaurant_id_foreign');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->dropForeign('category_restaurant_restaurant_id_foreign');
		});
		Schema::table('category_restaurant', function(Blueprint $table) {
			$table->dropForeign('category_restaurant_category_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_order_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_restaurant_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_client_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_payment_method_id_foreign');
		});
		Schema::table('payments', function(Blueprint $table) {
			$table->dropForeign('payments_restaurant_id_foreign');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->dropForeign('order_product_product_id_foreign');
		});
		Schema::table('order_product', function(Blueprint $table) {
			$table->dropForeign('order_product_order_id_foreign');
		});
	}
}