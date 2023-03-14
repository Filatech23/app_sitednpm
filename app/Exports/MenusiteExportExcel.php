<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MenusiteExportExcel implements FromCollection, WithHeadings,ShouldAutoSize {
	/**
	* @return \Illuminate\Support\Collection
	*/

	public function collection(){
		return session('xlsMenusite');
	} 

	public function  headings():array{
		return [
			trans('data.id_menusite'),
			trans('data.libelle_menu'),
			trans('data.ordre_menu'),
			trans('data.id_parent'),
			trans('data.type_affiche'),
			trans('data.etat_menu'),
			trans('data.motif_menu'),
			trans('data.init_id'),
		];
	}
}
