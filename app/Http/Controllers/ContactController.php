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
use App\Models\Contact;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactExportExcel;
use PDF;


class ContactController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $req) {

		$array = GiwuService::Path_Image_menu("/param/contact");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['list'] = Contact::getListContact($req)->paginate(20);
		if($req->ajax()) {
			return view('contact.index-search')->with($giwu);
		}
		return view('contact.index')->with($giwu);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
		$array = GiwuService::Path_Image_menu("/param/contact/create");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		return view('contact.create')->with($giwu);
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
				'nom_prenom_cont' => 'required',
				'mail_cont' => 'required',
				'sujet_cont' => 'required',
				'msg_cont' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$datas = $request->all();
				if(!filter_var($datas['mail_cont'], FILTER_VALIDATE_EMAIL)){ //Vérifier si c'est un bon mail...
					return response()->json(['response' => array('mail_cont' => 'E-mail incorrecte.')]);
				}
				unset($datas['_token']);
				//Enregistrement des donnees 
				$newAdd = new Contact();
				$newAdd->nom_prenom_cont = $datas['nom_prenom_cont'];
				$newAdd->mail_cont = $datas['mail_cont'];
				$newAdd->sujet_cont = $datas['sujet_cont'];
				$newAdd->msg_cont = $datas['msg_cont'];
				$newAdd->statut_cont = 'nt';  //non traité et traité
				$newAdd->traite_par = null;
				$newAdd->save(); 
				// GiwuSaveTrace::enregistre('Ajout du nouveau contact : '.GiwuService::DetailInfosInitial($newAdd->toArray()));
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
		$giwu['item'] = Contact::where('id_cont',$id)->first();
		return view('contact.delete')->with($giwu);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
		$array = GiwuService::Path_Image_menu("/param/contact/edit");
		if($array['titre']==""){return Redirect::to('weberror')->with(['typeAnswer' => trans('data.MsgCheckPage')]);}else{foreach($array as $name => $data){$giwu[$name] = $data;}}
		$giwu['item'] = Contact::where('id_cont',$id)->first();
		return view('contact.edit')->with($giwu);
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
				'nom_prenom_cont' => 'required',
				'mail_cont' => 'required',
				'sujet_cont' => 'required',
				'msg_cont' => 'required',
				'statut_cont' => 'required',
			]);

			if($validator->fails()){
				return response()->json(['response' => $validator->errors()]);
			}else{
				$dataInitiale = Contact::where('id_cont',$id)->first()->toArray();
				$datas = $request->all();
				unset($datas['_token']);

				$newUpd=Contact::where('id_cont',$id)->first();

				$newUpd->nom_prenom_cont = $datas['nom_prenom_cont'];
				$newUpd->mail_cont = $datas['mail_cont'];
				$newUpd->sujet_cont = $datas['sujet_cont'];
				$newUpd->msg_cont = $datas['msg_cont'];
				$newUpd->statut_cont = $datas['statut_cont'];
				$newUpd->traite_par = Auth::id();
				$newUpd->save();

				GiwuSaveTrace::enregistre("Modification contact : ".GiwuService::DiffDetailModifier($dataInitiale,$newUpd->toArray()));
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
			$dataInitiale = Contact::find($id)->toArray();
			$affectedRows = Contact::find($id)->delete();
			if ($affectedRows) {
				$dataSupp = GiwuService::DetailInfosInitial($dataInitiale);
				GiwuSaveTrace::enregistre("Suppression du contact : ".$dataSupp);
				return redirect()->route('contact.index')->with('success',trans('data.infos_delete'));
			}
		} catch (\Illuminate\Database\QueryException $e) {
			return Redirect::back()->withInput()->with('error',trans('data.infos_error'))->with("errorMsg",$e->getMessage());
		}
	}

	public function exporterExcel(Request $req) {
		$Resultat = Contact::getListContact($req)->get();
		if(sizeof($Resultat) != 0){
			$i = 0;
			foreach($Resultat as $giw){
				$tablgiwu[$i]['id_cont'] = $giw->id_cont;
				$tablgiwu[$i]['nom_prenom_cont'] = $giw->nom_prenom_cont;
				$tablgiwu[$i]['mail_cont'] = $giw->mail_cont;
				$tablgiwu[$i]['sujet_cont'] = $giw->sujet_cont;
				$tablgiwu[$i]['msg_cont'] = $giw->msg_cont;
				$tablgiwu[$i]['statut_cont'] = trans('entite.traite')[$giw->statut_cont];
				$tablgiwu[$i]['traite_par'] = isset($giw->users_g) ? $giw->users_g->name.' '.$giw->users_g->prenom : trans('data.not_found');
				$i++;
			}
			$Resultat = new Collection($tablgiwu);
		}
		Session()->put('xlsContact', $Resultat);
		return Excel::download(new ContactExportExcel, 'ContactExportExcel_'.date('Y-m-d-h-i-s').'.xls');
	}

	public function exporterPdf(Request $req) {
		$Resultat = Contact::getListContact($req)->get();
		$pdf = PDF::loadView('contact.pdf',['list' => $Resultat])->setPaper('a4','landscape');
		return $pdf->stream('contact-'.date('Ymdhis').'.pdf');
	}

	


}

