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

class Activite extends Model {

	protected $table = 'dnpmsiteg_activite';
	protected $primaryKey = 'id_activite';
	protected $guarded = array('*');
	public $timestamps = true;


	public function menusite(){return $this->belongsTo('App\Models\Menusite','menusite_id','id_menusite');}

	public function users_g(){return $this->belongsTo('App\Models\User','init_id','id');}

	public static function getListActivite(Request $req){

		$query = Activite::with(['menusite','users_g'])->orderBy('created_at','desc');

		$menusite_idv = $req->get('menusite_id');
		if(isset($menusite_idv)){
			if($menusite_idv != null && $menusite_idv != '' && $menusite_idv != '-1'){
				Session()->put('menusite_idSess', intval($menusite_idv));
			}
			$query->where('menusite_id',$req->get('menusite_id'));
		}else{
			$query->where('menusite_id',session('menusite_idSess'));
		}

		$recherche = $req->get('query');
		if(isset($recherche)){
			$query->where(function ($query) Use ($recherche){
				$query->orwhere('titre_act','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('descr_act','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('img_act','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('motif_act','like','%'.strtoupper(trim($recherche).'%'));
			});
			//Recherche avancee sur menusite
			$query->orWhereHas('menusite', function ($q) use ($recherche) {
				$q->where('libelle_menu', 'like', '%'.strtoupper(trim($recherche).'%'));
				$q->orwhere('route_menu', 'like', '%'.strtoupper(trim($recherche).'%'));
			});

			//Recherche avancee sur users
			$query->orWhereHas('users_g', function ($q) use ($recherche) {
				$q->where('name', 'like', '%'.strtoupper(trim($recherche).'%'));
				$q->orwhere('prenom', 'like', '%'.strtoupper(trim($recherche).'%'));
			});

		}
		if(in_array('transmettre_activite',session('InfosAction'))){
			$query->where('etat_act','e');
		}elseif(in_array('valider_activite',session('InfosAction'))){ //Si l'utilisateur � pour role Agent de validation
			$query->where('etat_act','<>','e');
		}
		return $query;
	}

	public static function sltListActivite(){
		$query = self::all()->pluck('titre_act','id_activite');
		return $query;
	}

}

