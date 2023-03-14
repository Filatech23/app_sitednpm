<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TouteimageExportExcel implements FromCollection, WithHeadings,ShouldAutoSize {
	/**
	* @return \Illuminate\Support\Collection
	*/

	public function collection(){
		return session('xlsTouteimage');
	} 

	public function  headings():array{
		return [
			trans('data.id_img'),
			trans('data.titre_img'),
			trans('data.img_fichier'),
			trans('data.etat_img'),
			trans('data.motif_img'),
			trans('data.init_id'),
			trans('data.link_img'),
			trans('data.type_rubri'),
		];
	}
}
