<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class Contact extends Model {

	protected $table = 'dnpmsiteg_contact';
	protected $primaryKey = 'id_cont';
	protected $guarded = array('*');
	public $timestamps = true;


	public function users_g(){return $this->belongsTo('App\Models\User','traite_par','id');}

	public static function getListContact(Request $req){

		$query = Contact::with(['users_g'])->orderBy('created_at','desc');

		$statut_contv = $req->get('statut_cont');
		if(isset($statut_contv)){
			if($statut_contv != null && $statut_contv != '' && $statut_contv != '-1'){
				Session()->put('statut_contSess', intval($statut_contv));
			}
			$query->where('statut_cont',$req->get('statut_cont'));
		}else{
			$query->where('statut_cont',session('statut_contSess'));
		}

		$recherche = $req->get('query');
		if(isset($recherche)){
			$query->where(function ($query) Use ($recherche){
				$query->orwhere('nom_prenom_cont','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('mail_cont','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('sujet_cont','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('msg_cont','like','%'.strtoupper(trim($recherche).'%'));
			});
			//Recherche avancee sur users
			$query->orWhereHas('users_g', function ($q) use ($recherche) {
				$q->where('name', 'like', '%'.strtoupper(trim($recherche).'%'));
				$q->orwhere('prenom', 'like', '%'.strtoupper(trim($recherche).'%'));
			});

		}
		return $query;
	}

	public static function sltListContact(){
		$query = self::all()->pluck('nom_prenom_cont','id_cont');
		return $query;
	}

}

