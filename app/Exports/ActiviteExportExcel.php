<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActiviteExportExcel implements FromCollection, WithHeadings,ShouldAutoSize {
	/**
	* @return \Illuminate\Support\Collection
	*/

	public function collection(){
		return session('xlsActivite');
	} 

	public function  headings():array{
		return [
			trans('data.id_activite'),
			trans('data.titre_act'),
			trans('data.descr_act'),
			trans('data.img_act'),
			trans('data.menusite_id'),
			trans('data.init_id'),
			trans('data.etat_act'),
			trans('data.motif_act'),
		];
	}
}
