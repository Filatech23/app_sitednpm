<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MenusiteSeeder extends Seeder {

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/


	public function run() {

		$topid = DB::select("SELECT id_menu  FROM dnpmsiteg_menu WHERE architecture = '/param'");

		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>'Menus du site','titre_page'=>'Menus du site',
			'controler'=>'MenusiteController','route'=>'menusite',
			'topmenu_id'=>$topid[0]->id_menu,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/menusite','elmt_menu'=>'oui',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_action_acces')->insert([
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Ajouter un menu','dev_action'=>'add_menusite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Modifier un menu','dev_action'=>'update_menusite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Supprimer un menu','dev_action'=>'delete_menusite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Valider contenu','dev_action'=>'valider_menusite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Transmettre contenu','dev_action'=>'transmettre_menusite',],
			['id_menu'=> $ok[0]->id,'libelle_action'=>'Exporter menusite','dev_action'=>'exporter_menusite',],
		]);

		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		$Last_menu = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		//Create
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Ajouter un menu",'titre_page'=>"Ajouter un menu",
			'controler'=>'MenusiteController','route'=>'menusite/create',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/menusite/create','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
		//Update
		DB::table('dnpmsiteg_menu')->insert([
			['libelle_menu'=>"Modifier un menu",'titre_page'=>"Modifier un menu",
			'controler'=>'MenusiteController','route'=>'menusite/edit',
			'topmenu_id'=>$Last_menu[0]->id,'user_id'=>'1',
			'menu_icon'=>'ri-bill-line','num_ordre'=>'1',
			'architecture'=>'/param/menusite/edit','elmt_menu'=>'non',
			],
		]);
		$ok = DB::select('SELECT MAX(id_menu) as id FROM dnpmsiteg_menu');
		DB::table('dnpmsiteg_role_acces')->insert([
			['id_menu'=> $ok[0]->id,'role_id'=>'1','statut_role'=>'1',],
		]);
	}
};
