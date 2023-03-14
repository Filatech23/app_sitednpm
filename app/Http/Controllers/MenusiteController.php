<?php

	/**
	* Giwu Services (E-mail: giwudev@gmail.com)
	* Code Generer by Giwu 
	*/
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\GiwuSaveTrace;
use App\Providers\GiwuService;
use Auth;
use App\Models\Menusite;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MenusiteExportExcel;
use PDF;
use Ramsey\Uuid\Uuid;

class MenusiteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req) {

		$array = GiwuService::Path_Image_menu("/param/menusite");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['list'] = Menusite::getListMenuSite($req)->paginate(20);
		$giwu['listid_parent'] = Menusite::sltListMenusiteParent();
		if($req->ajax()) {
			return view('menusite.index-search')->with($giwu);
		}
		return view('menusite.index')->with($giwu);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
		$array = GiwuService::Path_Image_menu("/param/menusite/create");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['listid_parent'] = Menusite::sltListMenusiteParent();
		return view('menusite.create')->with($giwu);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
		try {
			$validator = Validator::make($request->all(), [
				'libelle_menu' => 'required',
				'ordre_menu' => 'required',
				'type_affiche' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$datas = $request->all();
				unset($datas['_token']);
				//Enregistrement des donnees 
				$newAdd = new Menusite();
				$newAdd->code = Uuid::uuid4();
				$newAdd->libelle_menu = $datas['libelle_menu'];
				$newAdd->ordre_menu = $datas['ordre_menu'];
				$newAdd->id_parent = $datas['id_parent'];
				$newAdd->type_affiche = $datas['type_affiche'];
				//Si l'utilisateur a pour role Agent de saisie
				if(in_array('transmettre_menusite',session('InfosAction'))){
					$newAdd->etat_menu = 'e';
				}elseif(in_array('valider_menusite',session('InfosAction'))){ //Si l'utilisateur a pour role Agent de validation
					$newAdd->etat_menu = 't'; 
				}
				$newAdd->init_id = Auth::id();
				$newAdd->save(); 

				GiwuSaveTrace::enregistre('Ajout du nouveau menusite : '.GiwuService::DetailInfosInitial($newAdd->toArray()));
				
				return response()->json(['response' => 1]);
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return response()->json(['response' => 0,'message' => $e->getMessage()]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//Pop Up pour la suppression d'une ligne 
		$giwu['item'] = Menusite::where('id_menusite',$id)->first();
		return view('menusite.delete')->with($giwu);
	}

	//Methode pop up de validation 
	public function show_Validation($type,$id) {
		$giwu['type'] = $type;
		$giwu['item'] = Menusite::where('id_menusite',$id)->first();
		return view('menusite.transmettre')->with($giwu);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
		$array = GiwuService::Path_Image_menu("/param/menusite/edit");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['listid_parent'] = Menusite::sltListMenusiteParent();
		$giwu['item'] = Menusite::where('id_menusite',$id)->first();
		return view('menusite.edit')->with($giwu);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
		try {
			$validator = Validator::make($request->all(), [
				'libelle_menu' => 'required',
				'ordre_menu' => 'required',
				'type_affiche' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$dataInitiale = Menusite::where('id_menusite',$id)->first()->toArray();
				$datas = $request->all();
				unset($datas['_token']);

				$newUpd=Menusite::where('id_menusite',$id)->first();

				$newUpd->libelle_menu = $datas['libelle_menu'];
				$newUpd->ordre_menu = $datas['ordre_menu'];
				$newUpd->id_parent = $datas['id_parent'];
				$newUpd->type_affiche = $datas['type_affiche'];
				$newUpd->save();

				GiwuSaveTrace::enregistre("Modification menusite : ".GiwuService::DiffDetailModifier($dataInitiale,$newUpd->toArray()));
				return response()->json(['response' => 1]);
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return response()->json(['response' => 0,'message' => $e->getMessage()]);

		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
		try {
			$dataInitiale = Menusite::find($id)->toArray();
			$affectedRows = Menusite::find($id)->delete();
			if ($affectedRows) {
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre("Suppression du menusite : ".$dataSupp);
				return redirect()->route('menusite.index')->with('success',trans('data.infos_delete'));
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with("errorMsg",$e->getMessage());
		}
	}

	//Methode de transmission : Change Etat
	public function Validation($type,$id) {
		try {
			$info = ''; $gSave = '';
			$dataInitiale = Menusite::find($id)->toArray();
			$affectedRows = Menusite::find($id);
			if ($affectedRows) {
				if($type == 'trans'){
					$info = trans('data.infos_trans');
					$affectedRows->etat_menu = 't';
					$gSave = 'Transmission';
				}else if($type == 'go'){
					$info = trans('data.infos_go');
					$affectedRows->etat_menu = 'p';
					$gSave = 'Publication';
				}else if($type == 'stop'){
					$info = trans('data.infos_stop');
					$affectedRows->etat_menu = 't';
					$gSave = 'Arret de publication';
				}
				$affectedRows->save();
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre($gSave.' menusite : '.$dataSupp);
				return redirect()->route('menusite.index')->with('success',$info);
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with('errorMsg',$e->getMessage());
		}
	}

	public function exporterExcel(Request $req) {
		$Resultat = Menusite::getListMenuSite($req)->get();
		if(sizeof($Resultat) != 0){
			$i = 0;
			foreach($Resultat as $giw){
				$tablgiwu[$i]['id_menusite'] = $giw->id_menusite;
				$tablgiwu[$i]['libelle_menu'] = $giw->libelle_menu;
				$tablgiwu[$i]['ordre_menu'] = $giw->ordre_menu;
				$tablgiwu[$i]['menusite'] = isset($giw->menusite) ? $giw->menusite->libelle_menu : trans('data.not_found');
				$tablgiwu[$i]['type_affiche'] = trans('entite.type_affiche')[$giw->type_affiche];
				$tablgiwu[$i]['etat_menu'] = $giw->etat_menu;
				$tablgiwu[$i]['motif_menu'] = $giw->motif_menu;
				$tablgiwu[$i]['init_id'] = isset($giw->users_g) ? $giw->users_g->name.' '.$giw->users_g->prenom : trans('data.not_found');
				$i++;
			}
			$Resultat = new Collection($tablgiwu);
		}
		Session()->put('xlsMenusite', $Resultat);
		return Excel::download(new MenusiteExportExcel, 'MenusiteExportExcel_'.date('Y-m-d-h-i-s').'.xls');
	}

	public function exporterPdf(Request $req) {
		$Resultat = Menusite::getListMenuSite($req)->get();
		$pdf = PDF::loadView('menusite.pdf',['list' => $Resultat])->setPaper('a4','landscape');
		return $pdf->stream('menusite-'.date('Ymdhis').'.pdf');
	}

	public function AffichePopAction($id) {
		$giwu['item'] = Menusite::find($id);
		return view('menusite.action')->with($giwu);
	}

	public function  MotifGiwuAction(Request $req) {
		$validator = Validator::make($req->all(), [
		]);
		if($validator->fails()){
			return response()->json(['response' => $validator->errors()]);
		}else{
			$newUpd = Menusite::where('id_menusite',$req['id_menusite'])->first();
			$newUpd->etat_menu = 'e';
			$newUpd->save();

			return response()->json(['response' => 1]);

		}

	}

	


}

