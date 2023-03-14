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
use App\Models\Document;
use App\Models\Menusite;
use Validator;
use App\Utilities\FileStorage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocumentExportExcel;
use PDF;
use Ramsey\Uuid\Uuid;


class DocumentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req) {

		$array = GiwuService::Path_Image_menu("/param/docu");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['list'] = Document::getListDocument($req)->paginate(20);
		$giwu['listmenusite_id'] = Menusite::sltListMenusiteDocs();
		if($req->ajax()) {
			return view('docu.index-search')->with($giwu);
		}
		return view('docu.index')->with($giwu);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
		$array = GiwuService::Path_Image_menu("/param/docu/create");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['listmenusite_id'] = Menusite::sltListMenusiteDocs();
		return view('docu.create')->with($giwu);
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
				'nom_doc' => 'required',
				'telecharger_doc' => 'required',
				'menusite_id' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$datas = $request->all();
				if(!isset($datas['Fichier'])){
					return response()->json(['response' => array('Fichier' => 'Le champs est obligatoire.')]);
				}

				unset($datas['_token']);
				//Condition sur Fichier
				$datas['Fichier']="";
				$file1 = $request->file('Fichier');
				if($file1){
					$extension = strtolower($file1->getClientOriginalExtension());
					if($extension != 'pdf'){
						return response()->json(['response' => array('Fichier'=>'Le fichier doit être de type PDF.')]);
					}
					$filename=FileStorage::setFile('avatar',$file1,"","");
					$pathName = "assets/docs/";
					$file1->move($pathName, $filename);
					$datas['Fichier']=$filename;
				}
				//Enregistrement des donnees 
				$newAdd = new Document();
				$newAdd->code = Uuid::uuid4();
				$newAdd->nom_doc = $datas['nom_doc'];
				//Si l'utilisateur a pour role Agent de saisie
				if(in_array('transmettre_document',session('InfosAction'))){
					$newAdd->etat_doc = 'e';
				}elseif(in_array('valider_document',session('InfosAction'))){ //Si l'utilisateur a pour role Agent de validation
					$newAdd->etat_doc = 't';
				}
				$newAdd->Fichier = $datas['Fichier'];
				$newAdd->init_id = Auth::id();
				$newAdd->telecharger_doc = $datas['telecharger_doc'];
				$newAdd->menusite_id = $datas['menusite_id'];
				$newAdd->autre_inf = $datas['autre_inf'];
				$newAdd->save(); 

				GiwuSaveTrace::enregistre('Ajout du nouveau docu : '.GiwuService::DetailInfosInitial($newAdd->toArray()));
				
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
		$giwu['item'] = Document::where('id_doc',$id)->first();
		return view('docu.delete')->with($giwu);
	}

	//Methode pop up de validation 
	public function show_Validation($type,$id) {
		$giwu['type'] = $type;
		$giwu['item'] = Document::where('id_doc',$id)->first();
		return view('docu.transmettre')->with($giwu);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
		$array = GiwuService::Path_Image_menu("/param/docu/edit");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['listmenusite_id'] = Menusite::sltListMenusiteDocs();
		$giwu['item'] = Document::where('id_doc',$id)->first();
		return view('docu.edit')->with($giwu);
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
				'nom_doc' => 'required',
				'telecharger_doc' => 'required',
				'menusite_id' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$dataInitiale = Document::where('id_doc',$id)->first()->toArray();
				$datas = $request->all();
				unset($datas['_token']);

				$newUpd=Document::where('id_doc',$id)->first();

				if(!isset($newUpd->Fichier) && !isset($datas['Fichier'])){
					return response()->json(['response' => array('Fichier' => 'Le champs est obligatoire.')]);
				}

				//Condition de modification sur Fichier
				$datas['Fichier']=$newUpd->Fichier;
				$file1 = $request->file('Fichier');
				if($file1){
					// !is_null($newUpd->Fichier) && Filestorage::deleteFile('avatar',$newUpd->Fichier,"");
					$fichier = public_path()."/assets/docs/".$dataInitiale['Fichier'];
					if( file_exists ($fichier)){
						unlink($fichier) ;
						!is_null($newUpd->Fichier) && Filestorage::deleteFile('avatar',$newUpd->Fichier,"");
					}
					$extension = strtolower($file1->getClientOriginalExtension());
					if($extension != 'pdf'){
					return response()->json(['response' => array('Fichier' => 'Le fichier doit être de type PDF.')]);
					}
					$filename=FileStorage::setFile('avatar',$file1,"","");
					$pathName = "assets/docs/";
					$file1->move($pathName, $filename);
					$datas['Fichier']=$filename;
				}
				$newUpd->nom_doc = $datas['nom_doc'];
				$newUpd->Fichier = $datas['Fichier'];
				$newUpd->telecharger_doc = $datas['telecharger_doc'];
				$newUpd->menusite_id = $datas['menusite_id'];
				$newUpd->autre_inf = $datas['autre_inf'];
				$newUpd->save();

				GiwuSaveTrace::enregistre("Modification document : ".GiwuService::DiffDetailModifier($dataInitiale,$newUpd->toArray()));
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
			$dataInitiale = Document::find($id)->toArray();
			$affectedRows = Document::find($id)->delete();
			if ($affectedRows) {
				$fichier = public_path()."/assets/docs/".$dataInitiale['Fichier'];
				if( file_exists ($fichier)){
					unlink($fichier) ;
				}
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre("Suppression du document : ".$dataSupp);
				return redirect()->route('docu.index')->with('success',trans('data.infos_delete'));
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with("errorMsg",$e->getMessage());
		}
	}

	//Methode de transmission : Change Etat
	public function Validation($type,$id) {
		try {
			$info = ''; $gSave = '';
			$dataInitiale = Document::find($id)->toArray();
			$affectedRows = Document::find($id);
			if ($affectedRows) {
				if($type == 'trans'){
					$info = trans('data.infos_trans');
					$affectedRows->etat_doc = 't';
					$gSave = 'Transmission';
				}else if($type == 'go'){
					$info = trans('data.infos_go');
					$affectedRows->etat_doc = 'p';
					$gSave = 'Publication';
				}else if($type == 'stop'){
					$info = trans('data.infos_stop');
					$affectedRows->etat_doc = 't';
					$gSave = 'Arret de publication';
				}
				$affectedRows->save();
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre($gSave.' document : '.$dataSupp);
				return redirect()->route('docu.index')->with('success',$info);
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with('errorMsg',$e->getMessage());
		}
	}

	public function exporterExcel(Request $req) {
		$Resultat = Document::getListDocument($req)->get();
		if(sizeof($Resultat) != 0){
			$i = 0;
			foreach($Resultat as $giw){
				$tablgiwu[$i]['nom_doc'] = $giw->nom_doc;
				$tablgiwu[$i]['autre_inf'] = $giw->autre_inf;
				$tablgiwu[$i]['etat_doc'] = $giw->etat_doc;
				$tablgiwu[$i]['Fichier'] = $giw->Fichier;
				$tablgiwu[$i]['init_id'] = isset($giw->users_g) ? $giw->users_g->name.' '.$giw->users_g->prenom : trans('data.not_found');
				$tablgiwu[$i]['menusite'] = isset($giw->menusite) ? $giw->menusite->libelle_menu : trans('data.not_found');
				$tablgiwu[$i]['telecharger_doc'] = $giw->telecharger_doc;
				$tablgiwu[$i]['motif_doc'] = $giw->motif_doc;
				$i++;
			}
			$Resultat = new Collection($tablgiwu);
		}
		Session()->put('xlsDocument', $Resultat);
		return Excel::download(new DocumentExportExcel, 'DocumentExportExcel_'.date('Y-m-d-h-i-s').'.xls');
	}

	public function exporterPdf(Request $req) {
		$Resultat = Document::getListDocument($req)->get();
		$pdf = PDF::loadView('document.pdf',['list' => $Resultat])->setPaper('a4','landscape');
		return $pdf->stream('document-'.date('Ymdhis').'.pdf');
	}

	public function AffichePopAction($id) {
		$giwu['item'] = Document::find($id);
		return view('docu.action')->with($giwu);
	}

	public function  MotifGiwuAction(Request $req) {
		$validator = Validator::make($req->all(), [
			'motif_doc' => 'required',
		]);
		if($validator->fails()){
			return response()->json(['response' => $validator->errors()]);
		}else{
			$newUpd = Document::where('id_doc',$req['id_doc'])->first();
			$newUpd->etat_doc = 'e';
			$newUpd->motif_doc = $req->get('motif_doc');
			$newUpd->save();

			return response()->json(['response' => 1]);

		}

	}

	


}

