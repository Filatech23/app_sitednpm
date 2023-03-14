<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DocumentExportExcel implements FromCollection, WithHeadings,ShouldAutoSize {
	/**
	* @return \Illuminate\Support\Collection
	*/

	public function collection(){
		return session('xlsDocument');
	} 

	public function  headings():array{
		return [
			trans('data.nom_doc'),
			trans('data.autre_inf'),
			trans('data.etat_doc'),
			trans('data.Fichier'),
			trans('data.init_id'),
			trans('data.menusite_id'),
			trans('data.telecharger_doc'),
			trans('data.motif_doc'),
		];
	}
}
