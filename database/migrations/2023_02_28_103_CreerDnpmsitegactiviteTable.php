<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreerDnpmsitegactiviteTable extends Migration {

	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function up() {

		Schema::create('dnpmsiteg_activite', function (Blueprint $table) { 

			$table->bigIncrements('id_activite')->unsigned();
			$table->text('titre_act');
			$table->longText('descr_act')->nullable();
			$table->string('img_act')->nullable();
			$table->bigInteger('menusite_id')->unsigned();
			$table->bigInteger('init_id')->unsigned();
			$table->text('etat_act');
			$table->longText('motif_act')->nullable();
			$table->foreign('menusite_id')->references('id_menusite')->on('dnpmsiteg_menusite')->onDelete('set null');
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

		Schema::dropIfExists('dnpmsiteg_activite');

	}
}
