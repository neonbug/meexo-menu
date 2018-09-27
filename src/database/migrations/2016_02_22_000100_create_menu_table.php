<?php use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		Schema::create('menu', function(Blueprint $table)
		{
			$table->increments('id_menu');
			$table->boolean('visible');
			$table->integer('parent_id_menu')->unsigned()->nullable();
			$table->integer('ord');
			$table->timestamps();
			
			$table->foreign('parent_id_menu')->references('id_menu')->on('menu');
		});
		
		DB::table('role')->insert(
			['id_role' => 'menu', 'name' => 'Menu editor', 
				'created_at' => date('Y-m-d'), 'updated_at' => date('Y-m-d')]
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::drop('menu');
	}

}
