<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreerDnpmsitegcontactTable extends Migration {

	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function up() {

		Schema::create('dnpmsiteg_contact', function (Blueprint $table) { 

			$table->bigIncrements('id_cont')->unsigned();
			$table->string('nom_prenom_cont');
			$table->text('mail_cont');
			$table->text('sujet_cont');
			$table->longText('msg_cont');
			$table->text('statut_cont');
			$table->bigInteger('traite_par')->unsigned();
			$table->foreign('traite_par')->references('id')->on('users')->onDelete('set null');
			$table->timestamps();
		});
	}



	/**
	* Run the database .
	* Generer par generalForm (Giwu Richard - Richardtohon@gmail.com)
	* @return void
	*/

	public function down() {

		Schema::dropIfExists('dnpmsiteg_contact');

	}
}
