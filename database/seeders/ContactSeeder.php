<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ContactSeeder extends Seeder {

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/


	public function run() {

		$topid = DB::select("SELECT id_menu  FROM dnpmsiteg_menu WHERE architecture = '/param'");

		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>'Liste des contacts','titre_page'=>'Liste des contacts',
			'controler'=>'ContactController','route'=>'contact',
			'topmenu_id'=>$topid[0]->id_menu,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/contact','elmt_menu'=>'oui',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_action_acces')->insert([
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Ajouter un contact','dev_action'=>'add_contact',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Modifier un contact','dev_action'=>'update_contact',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Supprimer un contact','dev_action'=>'delete_contact',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Exporter contact','dev_action'=>'exporter_contact',],
		]);

		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		$Last_menu = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		//Create
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Ajouter un contact",'titre_page'=>"Ajouter un contact",
			'controler'=>'ContactController','route'=>'contact/create',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/contact/create','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		//Update
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Modifier un contact",'titre_page'=>"Modifier un contact",
			'controler'=>'ContactController','route'=>'contact/edit',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/contact/edit','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
	}
};
