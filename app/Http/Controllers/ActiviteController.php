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
use App\Models\Activite;
use App\Models\Menusite;
use Validator;
use App\Utilities\FileStorage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActiviteExportExcel;
use PDF;
use Ramsey\Uuid\Uuid;


class ActiviteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req) {
		
		$array = GiwuService::Path_Image_menu("/param/activite");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['list'] = Activite::getListActivite($req)->paginate(20);
		$giwu['listmenusite_id'] = Menusite::sltListMenusiteActiv();
		if($req->ajax()) {
			return view('activite.index-search')->with($giwu);
		}
		return view('activite.index')->with($giwu);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
		$array = GiwuService::Path_Image_menu("/param/activite/create");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['listmenusite_id'] = Menusite::sltListMenusiteActiv();
		return view('activite.create')->with($giwu);
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
				'titre_act' => 'required',
				'menusite_id' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$datas = $request->all();
				$content = $request->input('summary-ckeditor');
				// dd($datas,$content);
				unset($datas['_token']);
				//Condition sur Image
				$datas['img_act']="";
				$file1 = $request->file('img_act');
				if($file1){
					$extension = strtolower($file1->getClientOriginalExtension());
					if($extension != 'jpeg' && $extension != 'jpg' && $extension != 'png'){
						return response()->json(['response' => array('img_act'=>'Le fichier doit &ecirc;tre de type image (*.jpeg, *.jpg, *.png).')]);
					}
					$filename=FileStorage::setFile('avatar',$file1,"","");
					$pathName = "assets/docs/";
					$file1->move($pathName, $filename);
					$datas['img_act']=$filename;
				}
				//Enregistrement des donnees 
				$newAdd = new Activite();
				$newAdd->code = Uuid::uuid4();
				$newAdd->titre_act = $datas['titre_act'];
				$newAdd->descr_act = $datas['descr_act'];
				$newAdd->img_act = $datas['img_act'];
				$newAdd->menusite_id = $datas['menusite_id'];
				$newAdd->init_id = Auth::id();
				//Si l'utilisateur a pour role Agent de saisie
				if(in_array('transmettre_activite',session('InfosAction'))){
					$newAdd->etat_act = 'e';
				}elseif(in_array('valider_activite',session('InfosAction'))){ //Si l'utilisateur a pour role Agent de validation
					$newAdd->etat_act = 't';
				}
				$newAdd->save(); 

				GiwuSaveTrace::enregistre('Ajout du nouveau activite : '.GiwuService::DetailInfosInitial($newAdd->toArray()));
				
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
		$giwu['item'] = Activite::where('id_activite',$id)->first();
		return view('activite.delete')->with($giwu);
	}

	//Methode pop up de validation 
	public function show_Validation($type,$id) {
		$giwu['type'] = $type;
		$giwu['item'] = Activite::where('id_activite',$id)->first();
		return view('activite.transmettre')->with($giwu);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
		$array = GiwuService::Path_Image_menu("/param/activite/edit");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['listmenusite_id'] = Menusite::sltListMenusiteActiv();
		$giwu['item'] = Activite::where('id_activite',$id)->first();
		return view('activite.edit')->with($giwu);
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
				'titre_act' => 'required',
				'menusite_id' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$dataInitiale = Activite::where('id_activite',$id)->first()->toArray();
				$datas = $request->all();
				unset($datas['_token']);

				$newUpd=Activite::where('id_activite',$id)->first();

				//Condition de modification sur Image
				$datas['img_act']=$newUpd->img_act;
				$file1 = $request->file('img_act');
				if($file1){
					$fichier = public_path()."/assets/docs/".$dataInitiale['img_act'];
					if( file_exists ($fichier)){
						unlink($fichier) ;
						!is_null($newUpd->img_act) && Filestorage::deleteFile('avatar',$newUpd->img_act,"");
					}
					// !is_null($newUpd->img_act) && Filestorage::deleteFile('avatar',$newUpd->img_act,"");
					$extension = strtolower($file1->getClientOriginalExtension());
					if($extension != 'jpeg' && $extension != 'jpg' && $extension != 'png'){
					return response()->json(['response' => array('img_act' => 'Le fichier doit &ecirc;tre de type image (*.jpeg, *.jpg, *.png).')]);
					}
					$filename=FileStorage::setFile('avatar',$file1,"","");
					$pathName = "assets/docs/";
					$file1->move($pathName, $filename);
					$datas['img_act']=$filename;
				}
				$newUpd->titre_act = $datas['titre_act'];
				$newUpd->descr_act = $datas['descr_act'];
				$newUpd->img_act = $datas['img_act'];
				$newUpd->menusite_id = $datas['menusite_id'];
				$newUpd->save();

				GiwuSaveTrace::enregistre("Modification activite : ".GiwuService::DiffDetailModifier($dataInitiale,$newUpd->toArray()));
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
			$dataInitiale = Activite::find($id)->toArray();
			$affectedRows = Activite::find($id)->delete();
			if ($affectedRows) {
				$fichier = public_path()."/assets/docs/".$dataInitiale['img_act'];
				if( file_exists ($fichier)){
					unlink($fichier) ;
				}
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre("Suppression du activite : ".$dataSupp);
				return redirect()->route('activite.index')->with('success',trans('data.infos_delete'));
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with("errorMsg",$e->getMessage());
		}
	}

	//Methode de transmission : Change Etat
	public function Validation($type,$id) {
		try {
			$info = ''; $gSave = '';
			$dataInitiale = Activite::find($id)->toArray();
			$affectedRows = Activite::find($id);
			if ($affectedRows) {
				if($type == 'trans'){
					$info = trans('data.infos_trans');
					$affectedRows->etat_act = 't';
					$gSave = 'Transmission';
				}else if($type == 'go'){
					$info = trans('data.infos_go');
					$affectedRows->etat_act = 'p';
					$gSave = 'Publication';
				}else if($type == 'stop'){
					$info = trans('data.infos_stop');
					$affectedRows->etat_act = 't';
					$gSave = 'Arret de publication';
				}
				$affectedRows->save();
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre($gSave.' activite : '.$dataSupp);
				return redirect()->route('activite.index')->with('success',$info);
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with('errorMsg',$e->getMessage());
		}
	}

	public function exporterExcel(Request $req) {
		$Resultat = Activite::getListActivite($req)->get();
		if(sizeof($Resultat) != 0){
			$i = 0;
			foreach($Resultat as $giw){
				$tablgiwu[$i]['id_activite'] = $giw->id_activite;
				$tablgiwu[$i]['titre_act'] = $giw->titre_act;
				$tablgiwu[$i]['descr_act'] = $giw->descr_act;
				$tablgiwu[$i]['img_act'] = $giw->img_act;
				$tablgiwu[$i]['menusite'] = isset($giw->menusite) ? $giw->menusite->libelle_menu : trans('data.not_found');
				$tablgiwu[$i]['init_id'] = isset($giw->users_g) ? $giw->users_g->name.' '.$giw->users_g->prenom : trans('data.not_found');
				$tablgiwu[$i]['etat_act'] = $giw->etat_act;
				$tablgiwu[$i]['motif_act'] = $giw->motif_act;
				$i++;
			}
			$Resultat = new Collection($tablgiwu);
		}
		Session()->put('xlsActivite', $Resultat);
		return Excel::download(new ActiviteExportExcel, 'ActiviteExportExcel_'.date('Y-m-d-h-i-s').'.xls');
	}

	public function exporterPdf(Request $req) {
		$Resultat = Activite::getListActivite($req)->get();
		$pdf = PDF::loadView('activite.pdf',['list' => $Resultat])->setPaper('a4','landscape');
		return $pdf->stream('activite-'.date('Ymdhis').'.pdf');
	}

	public function AffichePopAction($id) {
		$giwu['item'] = Activite::find($id);
		return view('activite.action')->with($giwu);
	}

	public function  MotifGiwuAction(Request $req) {
		$validator = Validator::make($req->all(), [
			'motif_act' => 'required',
		]);
		if($validator->fails()){
			return response()->json(['response' => $validator->errors()]);
		}else{
			$newUpd = Activite::where('id_activite',$req['id_activite'])->first();
			$newUpd->etat_act = 'e';
			$newUpd->motif_act = $req->get('motif_act');
			$newUpd->save();

			return response()->json(['response' => 1]);

		}

	}

	


}

