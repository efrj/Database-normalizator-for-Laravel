<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('table_id')->nullable()->index('table_id_idx');
			$table->string('field_name', 100)->nullable();
			$table->string('field_type', 45)->nullable();
			$table->string('field_null', 5)->nullable();
			$table->string('field_key', 45)->nullable();
			$table->string('field_default', 45)->nullable();
			$table->string('standard_attribute', 100)->nullable();
			$table->string('field_extra', 45)->nullable();
			$table->string('table_related_name', 100)->nullable();
			$table->string('field_related_name', 100)->nullable();
			$table->string('type_related', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fields');
	}

}
