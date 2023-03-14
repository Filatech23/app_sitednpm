<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreerDnpmsitegmenusiteTable extends Migration {

	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function up() {

		Schema::create('dnpmsiteg_menusite', function (Blueprint $table) { 

			$table->bigIncrements('id_menusite')->unsigned();
			$table->text('libelle_menu');
			$table->bigInteger('ordre_menu');
			$table->bigInteger('id_parent')->nullable()->unsigned();
			$table->text('route_menu');
			$table->text('etat_menu');
			$table->text('motif_menu')->nullable();
			$table->bigInteger('init_id');
			$table->foreign('id_parent')->references('id_menusite')->on('dnpmsiteg_menusite')->onDelete('set null');
			$table->foreign('init_id')->references('id')->on('users')->onDelete('set null');
			$table->timestamps();
		});
	}



	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function down() {

		Schema::dropIfExists('dnpmsiteg_menusite');

	}
}
