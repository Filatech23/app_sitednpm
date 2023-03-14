<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activite;
use Auth;

class Menusite extends Model {

	protected $table = 'dnpmsiteg_menusite';
	protected $primaryKey = 'id_menusite';
	protected $guarded = array('*');
	public $timestamps = true;


	public function menusite(){return $this->belongsTo('App\Models\Menusite','id_parent','id_menusite');}

	public function users_g(){return $this->belongsTo('App\Models\User','init_id','id');}

	public static function getListMenuSite(Request $req){

		$query = Menusite::with(['menusite','users_g'])->orderBy('ordre_menu','asc');

		$id_parentv = $req->get('id_parent');
		if(isset($id_parentv)){
			if($id_parentv != '-1'){
				Session()->put('id_parentSess', $id_parentv);
				$query->where('id_parent',$req->get('id_parent'));
			}else{
				Session()->put('id_parentSess', '-1');
				$query->where('id_parent',null);
			}
		}else{
			if(session('id_parentSess') == '-1'){
				$query->where('id_parent',null);
				Session()->put('id_parentSess', null);
			}else{
				$query->where('id_parent',session('id_parentSess'));
			}
		}

		$recherche = $req->get('query');
		if(isset($recherche)){
			$query->where(function ($query) Use ($recherche){
				$query->orwhere('libelle_menu','like','%'.strtoupper(trim($recherche).'%'));
				$query->orwhere('motif_menu','like','%'.strtoupper(trim($recherche).'%'));
			});

			//Recherche avancee sur users
			$query->orWhereHas('users_g', function ($q) use ($recherche) {
				$q->where('name', 'like', '%'.strtoupper(trim($recherche).'%'));
				$q->orwhere('prenom', 'like', '%'.strtoupper(trim($recherche).'%'));
			});

		}
		if(in_array('transmettre_menusite',session('InfosAction'))){
			$query->where('etat_menu','e');
		}elseif(in_array('valider_menusite',session('InfosAction'))){ //Si l'utilisateur à pour role Agent de validation
			$query->where('etat_menu','<>','e');
		}
		return $query;
	}

	public static function sltListMenusiteParent(){
		$query = self::where('id_parent',null)->pluck('libelle_menu','id_menusite');
		return $query;
	}

	public static function sltListMenusite(){
		$query = self::orderBy('libelle_menu','asc')->pluck('libelle_menu','id_menusite');
		return $query;
	}

	public static function sltListMenusiteActiv(){
		$query = self::where('type_affiche','<>','d')->orderBy('libelle_menu','asc')->pluck('libelle_menu','id_menusite');
		return $query;
	}

	public static function sltListMenusiteDocs(){
		$query = self::where('type_affiche','d')->orderBy('libelle_menu','asc')->pluck('libelle_menu','id_menusite');
		return $query;
	}

	public static function SousMenu($idmenu){
		$query = self::where('id_parent',$idmenu)->where('type_affiche','<>','pa')->orderBy('ordre_menu','asc')->get();
		return $query;
	}

	public static function returnLink($idmenu){
		$query = self::where('id_menusite',$idmenu)->first();
		if($query){
			return 'c'.trans('data.val_giwu').$query->code; // c = containt
		}
		return '#';
	}

	public static function returnLinkActivit($id_acti){

		$query = Activite::where('id_activite',$id_acti)->first();
		if($query){
			return 'ca'.trans('data.val_giwu').$query->code; // ca = containt des activités
		}
		return '#';
	}

}

