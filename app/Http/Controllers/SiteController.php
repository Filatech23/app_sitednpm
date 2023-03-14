<?php

	/**
	* Giwu Service (E-mail: giwuservices@gmail.com)
	* Code Genere by GENERRATE-CMS
    */
    
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Utilities\FileStorage;
use Illuminate\Support\Facades\DB;
use App\Providers\GiwuService;
use Validator;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Models\GiwuSaveTrace;
use Auth,Hash;
use App\Models\User;
use App\Models\GiwuSociete;
use App\Models\Document;
use App\Models\Activite;
use App\Models\Menusite;
use Ramsey\Uuid\Uuid;


class SiteController extends Controller
{

    public static function index(){
       
        //Affichage des menus 
        $menu = Menusite::where('etat_menu','p')->where('id_parent',null)->where('type_affiche','<>','pa')->get();
        $giwu['menusit'] = $menu;

        //Récuperer les 5 derniers éléments modifiés dans l'activité 6 = Activité
        $activ = Activite::where('etat_act','p')->where('menusite_id',6)->orderBy('created_at','desc')->get();
        $giwu['activit'] = $activ;
        
        $Countactiv = Menusite::where('etat_menu','p')->where('id_menusite',6)->count();
        $giwu['Countactiv'] = $Countactiv;
        
        $societe = GiwuSociete::where('id_societe',1)->first();
        $giwu['societe'] = $societe;
        
        //A propos = 2
        $apropos = Activite::where('etat_act','p')->where('menusite_id',2)->first();
        $giwu['apropos'] = $apropos;
        $aproposmenu = Menusite::where('etat_menu','p')->where('id_menusite',2)->first();
        $giwu['aproposmenu'] = $aproposmenu;

        //Mot du direteur
        $activ = Activite::where('etat_act','p')->where('menusite_id',22)->first();
        $giwu['motdirect'] = $activ;

        //Statistique
        $activ = Activite::where('etat_act','p')->where('menusite_id',23)->get();
        $giwu['statistique'] = $activ;

        //Organisations
        $activ = Activite::where('etat_act','p')->where('menusite_id',24)->get();
        $giwu['organisa'] = $activ;
        $activ = Menusite::where('etat_menu','p')->where('id_menusite',24)->first();
        $giwu['organisaFirst'] = $activ;
        
        //Liste des personnels
        $activ = Activite::where('etat_act','p')->where('menusite_id',25)->get();
        $giwu['listPerson'] = $activ;
        $activ = Menusite::where('etat_menu','p')->where('id_menusite',25)->first();
        $giwu['listPersonFirst'] = $activ;
        
        //Liste des partenaires
        $activ = Activite::where('etat_act','p')->where('menusite_id',26)->get();
        $giwu['listPartena'] = $activ;
        $activ = Menusite::where('etat_menu','p')->where('id_menusite',26)->first();
        $giwu['listPartenaFirst'] = $activ;

        return view('site.home')->with($giwu);
    }
    

    public static function recupcode($contain,$code){
       
        // dd($contain,$code);
        $menu = Menusite::where('etat_menu','p')->where('id_parent',null)->where('type_affiche','<>','pa')->get();
        $societe = GiwuSociete::where('id_societe',1)->first();
        
        $giwu['societe'] = $societe;
        $giwu['menusit'] = $menu;
        
        if($contain == 'l'){ //Liste
            $infos_menu = Menusite::where('etat_menu','p')->where('code',$code)->first();
            if($infos_menu){
                $giwu['infoMenu'] = $infos_menu;
                //Infos sur les activités
                $activ = Activite::where('etat_act','p')->where('menusite_id',$infos_menu->id_menusite)->orderBy('created_at','desc')->paginate(10);
                $giwu['listactivite'] = $activ;

                return view('site.list')->with($giwu);
            }
        }else if($contain == 'c'){  //Contenu
            
            $infos_menu = Menusite::where('etat_menu','p')->where('code',$code)->first();
            if($infos_menu){
                $giwu['infoMenu'] = $infos_menu;
                //Infos sur les activités
                $activ = Activite::where('etat_act','p')->where('menusite_id',$infos_menu->id_menusite)->first();
                $giwu['activite'] = $activ;
                
                return view('site.contains')->with($giwu);
            }
        }else if($contain == 'ca'){ //
            
            $infos_act = Activite::where('etat_act','p')->where('code',$code)->first();
            if($infos_act){
                $infos_menu = Menusite::where('etat_menu','p')->where('id_menusite',$infos_act->menusite_id)->first();
                $giwu['infoMenu'] = $infos_menu;
                //Infos sur les activités
                $giwu['activite'] = $infos_act;
                
                return view('site.contains')->with($giwu);
            }
        }else if($contain == 'd'){ //
            
            $infos_menu = Menusite::where('etat_menu','p')->where('code',$code)->first();
            if($infos_menu){
                $giwu['infoMenu'] = $infos_menu;
                //Infos sur les documents
                $activ = Document::where('etat_doc','p')->where('menusite_id',$infos_menu->id_menusite)->orderBy('created_at','desc')->paginate(10);
                $giwu['listDocument'] = $activ;

                return view('site.tableau')->with($giwu);
            }
        }
        return Redirect::to('/'); //Faire une redirection vers la page d'accueil si la ligne n'est pas trouvée
    }
    
    public static function infos_contact(){
        
        return view('site.contact');
    }
    
    
    public static function LogoutAgent(){
        Session()->forget('InfosAgent');  
        return Redirect::to('/');
    }
    
    public function connexionAgent(Request $request){
        
        try {
            // $datas = $request->all();
            // if($datas['matricule'] == ""){
            //     return Redirect::back()->withInput()->with('error',"Renseigner le matricule.");
            // }elseif($datas['password'] == ""){
            //     return Redirect::back()->withInput()->with('error',"Renseigner le mot de passe.");
            // }else{
            //     //Vérifier si le matricule existe dans la base 
            //     $check = Agent::with(['entite'])->where('matricule_ag',$datas['matricule'])->first();
            //     if(isset($check)){
            //         //Vérifier si l'agent appartient à un plan avant l'inscription
            //         $assCh = Associeragent::where('agent_id',$check->id_ag)->first();
            //         if(isset($assCh)){
            //             if($check->mdp_ag == sha1($datas['password'])){
            //                 // dd('okok');
            //                 self::ChangerSession($check);
            //                 return Redirect::to('mypage');
            //             }else if($check->mdp_ag == null || $check->mdp_ag == ''){
            //                 return Redirect::back()->withInput()->with('error',"Inscrivez-vous avant de vous connecter");
            //             }else{
            //                 return Redirect::back()->withInput()->with('error',"Mot de passe incorrecte.");
            //             }
            //         }else{
            //             return Redirect::back()->withInput()->with('error',"Ce matricule n'est inscrit dans aucun plan de formation.");
            //         }
            //     }else{
            //         return Redirect::back()->withInput()->with('error',"Ce matricule n'existe pas");
            //     }
            // }
        } catch (\Illuminate\Database\QueryException $e) {
            return Redirect::back()->withInput()->with('error',"Erreur de connexion");
        }
    }
    
    public function InscriptionAgent(Request $request){
        
        try {

            $datas = $request->all();
            if($datas['matricule'] == ""){
                return Redirect::back()->withInput()->with('error',"Renseigner le matricule.");
            }elseif($datas['mail_ag'] == ""){
                return Redirect::back()->withInput()->with('error',"Renseigner l'e-mail.");
            }elseif($datas['tel_ag'] == ""){
                return Redirect::back()->withInput()->with('error',"Renseigner le téléphone.");
            }elseif($datas['userpassword'] == ""){
                return Redirect::back()->withInput()->with('error',"Renseigner le mot de passe.");
            }else{
                //Vérifier si le matricule existe dans la base 
                $check = Agent::with(['entite'])->where('matricule_ag',$datas['matricule'])->first();
                if(isset($check)){
                    //Vérifier si l'agent appartient à un plan avant l'inscription
                    $assCh = Associeragent::where('agent_id',$check->id_ag)->first();
                    if(!isset($assCh)){
                        return Redirect::back()->withInput()->with('error',"Impossible de valider cette inscription car ce matricule n'a aucun plan de formation en vue.");
                    }else{
                        //Vérifier la confirmation du mot de passe 
                        if($datas['confiPassword'] != $datas['userpassword']){
                            return Redirect::back()->withInput()->with('error',"Confirmation du mot de passe incorrecte.");
                        }
                        //MEttre a jour les données de l'agent dans la base 
                        $check->mail_ag = $datas['mail_ag'];
                        $check->tel_ag = $datas['tel_ag'];
                        $check->mdp_ag = sha1($datas['userpassword']);
                        $check->save();
                        // dd('Redirection');
                        self::ChangerSession($check);
                        return Redirect::to('mypage');
                    }
                }else{
                    return Redirect::back()->withInput()->with('error',"Impossible de valider cette inscription car ce matricule n'existe pas déjà.");
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return Redirect::back()->withInput()->with('error',"Erreur de connexion");
        }
    }

    public static function ChangerSession($check){
        Session()->put('InfosAgent', $check);
        Session()->put('DateCnx', date('Y-m-d'));
    }    

    public static function espaceAgent(){

        return view('site.agent.espace');
    } 

    
	public function Aff_CreateDossier($id,$type) {

        // 'pf' => 'Plan de formation',
        // 'ms' => 'Mise en stage',
        // 'rs' => 'Retour de stage',
        
		return view('site.agent.addossier');
	}

    public function CreateDossierAgent(Request $request) {
		//
		try {
            // $datas = $request->all();
            // $id = $datas['id_pf'];
            // $type = $datas['type_dos'];
			// $piece = Associerpiece::with(['users_g'])
            //                         ->where('type_piece',$type)->get();
            // //Vérifier s'il y une demande encours
            // $dossier_compt = Dossier::where('plan_id',$id)
            //                         ->where('agent_id',session('InfosAgent')->id_ag)
            //                         ->where('etat_dossier','<>','r')
            //                         ->where('type_dossier',$type)
            //                         ->count();
            // if($dossier_compt != 0 ){
            //     return response()->json(['response' => array('GlobalError' => 'Impossible d\'ajouter de déposer ce dossier il y a déjà un encours.')]);
            // }
            // //Controle sur les pièces jointes
            // $trv = 0; $cpt = 0;
            // if(count($piece) != 0){
            //     foreach($piece as $pi){
            //         $cpt++;
            //         $file1 = $request->file('fichier'.$pi->id_asspj);
            //         if($pi->requis_file == "Oui"){
            //             if(!$file1){
            //                 return response()->json(['response' => array('fichier'.$pi->id_asspj => 'Le champs est obligatoire.')]);
            //             }
            //         }
            //         if(!$request->file('fichier'.$pi->id_asspj)){ $trv++;   }
            //     }
            // }
            // if($trv != $cpt){

            //     $newAdd = new Dossier();
            //     $newAdd->code = Uuid::uuid4();
            //     $newAdd->etat_dossier = 's';
            //     $newAdd->type_dossier = $type;
            //     $newAdd->avis_motive = '';
            //     $newAdd->agent_id = session('InfosAgent')->id_ag;
            //     $newAdd->entite_id = session('InfosAgent')->entite_id;
            //     $newAdd->plan_id = $id;
            //     $newAdd->save();

            //     //Ajouter la transmission
            //     $Newtran = new Transmission();
            //     $Newtran->code = Uuid::uuid4();
            //     $Newtran->from = '-1';
            //     $Newtran->to = '7'; // Rôle DPAF par défaut 
            //     $Newtran->dossier_id = $newAdd->id_dossier;
            //     $Newtran->detail_trans = "Soumission de dossier";
            //     $Newtran->is_last = true;
            //     $Newtran->do_by = null;
            //     $Newtran->etat_trans = 's';
            //     $Newtran->motif = null;
            //     $Newtran->save();

            //     //Ajouter les fichiers joints 
            //     if(count($piece) != 0){
            //         foreach($piece as $pi){
            //             $file1 = $request->file('fichier'.$pi->id_asspj);
            //             if($file1){
            //                 $filename=FileStorage::setFile('avatar',$file1,"","");
            //                 $pathName = "assets/docs/";
            //                 $file1->move($pathName, $filename);
            //                 // $datas['fichier_plan']=$filename;
            //                 $extension = strtolower($file1->getClientOriginalExtension());
            //                 //Ajouter les fichiers  
            //                 $fildoss = new FileDossier();
            //                 // $fildoss->fichier_file = $pi->libelle_asspj.'.'.$extension;
            //                 $fildoss->fichier_file = $filename;
            //                 $fildoss->dossier_id  = $newAdd->id_dossier;
            //                 $fildoss->piece_id  = $pi->id_asspj;
            //                 $fildoss->save();
            //             }
            //         }
            //     }
            // }else{
            //     return response()->json(['response' => array('GlobalError' => 'Aucun fichier n\'est attaché.')]);
            // }
			// GiwuSaveTrace::enregistre('Ajout d\'un nouveau dossier : '.GiwuService::DetailInfosInitial($newAdd->toArray()));
			return response()->json(['response' => 1]);
		} catch (\Illuminate\Database\QueryException $e) {
			return response()->json(['response' => 0,'message' => $e->getMessage()]);

		}
	}

	public function Aff_ParcoursDossier($id) {
		//
		return view('site.agent.Parcoursdossier');
	}
}
