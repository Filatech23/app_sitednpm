<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DocumentSeeder extends Seeder {

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/


	public function run() {

		$topid = DB::select("SELECT id_menu  FROM dnpmsiteg_menu WHERE architecture = '/param'");

		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>'Liste des documents','titre_page'=>'Liste des documents',
			'controler'=>'DocumentController','route'=>'document',
			'topmenu_id'=>$topid[0]->id_menu,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/document','elmt_menu'=>'oui',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_action_acces')->insert([
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Ajouter un document','dev_action'=>'add_document',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Modifier un document','dev_action'=>'update_document',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Supprimer un document','dev_action'=>'delete_document',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Valider contenu','dev_action'=>'valider_document',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Transmettre contenu','dev_action'=>'transmettre_document',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Exporter document','dev_action'=>'exporter_document',],
		]);

		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		$Last_menu = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		//Create
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Ajouter un document",'titre_page'=>"Ajouter un document",
			'controler'=>'DocumentController','route'=>'document/create',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/document/create','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		//Update
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Modifier un document",'titre_page'=>"Modifier un document",
			'controler'=>'DocumentController','route'=>'document/edit',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/document/edit','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
	}
};
