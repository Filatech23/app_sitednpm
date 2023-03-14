<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ContactExportExcel implements FromCollection, WithHeadings,ShouldAutoSize {
	/**
	* @return \Illuminate\Support\Collection
	*/

	public function collection(){
		return session('xlsContact');
	} 

	public function  headings():array{
		return [
			trans('data.id_cont'),
			trans('data.nom_prenom_cont'),
			trans('data.mail_cont'),
			trans('data.sujet_cont'),
			trans('data.msg_cont'),
			trans('data.statut_cont'),
			trans('data.traite_par'),
		];
	}
}
