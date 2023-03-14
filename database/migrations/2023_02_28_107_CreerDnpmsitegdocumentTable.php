<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreerDnpmsitegdocumentTable extends Migration {

	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function up() {

		Schema::create('dnpmsiteg_document', function (Blueprint $table) { 

			$table->bigIncrements('id_doc')->unsigned();
			$table->text('nom_doc');
			$table->longText('autre_inf');
			$table->string('Fichier');
			$table->string('telecharger_doc');
			$table->bigInteger('init_id')->unsigned();
			$table->text('etat_doc');
			$table->longText('motif_doc')->nullable();
			$table->bigInteger('menusite_id')->unsigned();
			$table->foreign('init_id')->references('id')->on('users')->onDelete('set null');
			$table->foreign('menusite_id')->references('id_menusite')->on('dnpmsiteg_menusite')->onDelete('set null');
			$table->timestamps();
		});
	}



	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function down() {

		Schema::dropIfExists('dnpmsiteg_document');

	}
}
