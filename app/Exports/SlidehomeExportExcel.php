<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SlidehomeExportExcel implements FromCollection, WithHeadings,ShouldAutoSize {
	/**
	* @return \Illuminate\Support\Collection
	*/

	public function collection(){
		return session('xlsSlidehome');
	} 

	public function  headings():array{
		return [
			trans('data.id_slide'),
			trans('data.titre'),
			trans('data.etat_slide'),
			trans('data.motif'),
			trans('data.image_slide'),
			trans('data.init_id'),
		];
	}
}
