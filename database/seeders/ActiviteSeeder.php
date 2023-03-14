<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ActiviteSeeder extends Seeder {

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/


	public function run() {

		$topid = DB::select("SELECT id_menu  FROM dnpmsiteg_menu WHERE architecture = '/param'");

		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>'Liste des activites','titre_page'=>'Liste des activites',
			'controler'=>'ActiviteController','route'=>'activite',
			'topmenu_id'=>$topid[0]->id_menu,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/activite','elmt_menu'=>'oui',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_action_acces')->insert([
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Ajouter une activite','dev_action'=>'add_activite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Modifier une activite','dev_action'=>'update_activite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Supprimer une activite','dev_action'=>'delete_activite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Valider contenu','dev_action'=>'valider_activite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Transmettre contenu','dev_action'=>'transmettre_activite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Exporter activite','dev_action'=>'exporter_activite',],
		]);

		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		$Last_menu = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		//Create
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Ajouter une activite",'titre_page'=>"Ajouter une activite",
			'controler'=>'ActiviteController','route'=>'activite/create',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/activite/create','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		//Update
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Modifier une activite",'titre_page'=>"Modifier une activite",
			'controler'=>'ActiviteController','route'=>'activite/edit',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/activite/edit','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
	}
};
