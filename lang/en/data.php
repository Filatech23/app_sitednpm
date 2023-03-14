<?php

return [
    /*
    |--------------------------------------------------------------------------
    |   UTILISATEUR
    |--------------------------------------------------------------------------
    */
    'id_user'=>'Utilisateur',
    'name'=>'Nom',
    'prenom'=>'Prénom(s)',
    'email'=>'E-mail',
    'tel_user'=>'Téléphone',
    'other_infos_user'=>'Autres infos.',
    'id_role'=>'Rôle',
    'id_ini'=>'Initiateur',
    'is_active'=>'Etat du compte',
    'entite_id'=>'Entité',
    
    /*
    |--------------------------------------------------------------------------
    |   MENU
    |--------------------------------------------------------------------------
    */
    'id_menu'=>'Identifiant',
    'libelle_menu'=>'Menu',
    'menu_icon'=>'Icône',
    'num_ordre'=>'N° Ordre',
    'order_ss'=>'order_ss',
    'route'=>'Route',
    'titre_page'=>'Titre page',
    'topmenu_id'=>'Menu parent',
    'user_id'=>'Initiateur',
    'architecture'=>'Architecture',
    'controler'=>'Contrôler',
    'elmt_menu'=>'Appartient au menu',
    'role' => 'Rôle',
    'libelle_action'=>'Action',
    'dev_action'=>'Dev Action',
    /*
    |--------------------------------------------------------------------------
    |   ROLE
    |--------------------------------------------------------------------------
    */
    'id_role'=>'Identifiant',
    'libelle_role'=>'Rôle',
    'sous_role'=>'Sous Rôle',
    'user_save_id'=>'Initiateur',
    'libelle_trace'=>'Trace',
    'created_at'=>'Date opération',


	/*
	|--------------------------------------------------------------------------
	|   MENUSITE
	|--------------------------------------------------------------------------
	*/
	'id_menusite'=>'Identifiant',
	'libelle_menu'=>'Menu',
	'ordre_menu'=>'Ordre',
	'id_parent'=>'Parent',
	'type_affiche'=>'Type d\'affichage',
	'etat_menu'=>'Etat',
	'motif_menu'=>'Motif',
	'init_id'=>'Initiateur',

	/*
	|--------------------------------------------------------------------------
	|   ACTIVITE
	|--------------------------------------------------------------------------
	*/
	'id_activite'=>'Identifiant',
	'titre_act'=>'Titre',
	'descr_act'=>'Description',
	'img_act'=>'Image',
	'menusite_id'=>'Menu',
	'init_id'=>'Initiateur',
	'etat_act'=>'Etat',
	'motif_act'=>'Motif',

	/*
	|--------------------------------------------------------------------------
	|   CONTACT
	|--------------------------------------------------------------------------
	*/
	'id_cont'=>'Identifiant',
	'nom_prenom_cont'=>'Nom',
	'mail_cont'=>'E-mail',
	'sujet_cont'=>'Sujet',
	'msg_cont'=>'Message',
	'statut_cont'=>'Status',
	'traite_par'=>'Traite par',

	/*
	|--------------------------------------------------------------------------
	|   DOCUMENT
	|--------------------------------------------------------------------------
	*/
	'id_doc'=>'Identifiant',
	'nom_doc'=>'Nom',
	'autre_inf'=>'Autres informations.',
	'etat_doc'=>'Etat',
	'Fichier'=>'Fichier',
	'init_id'=>'Initiateur',
	'menusite_id'=>'Menusite',
	'telecharger_doc'=>'Telecharger',
	'motif_doc'=>'Motif',

	//data-giwu-cms
    
	
    'not_found_direc' => '--',
    'not_found' => 'Non trouvé',
    'img_defaut' => 'defaut.jpg',
    'val_giwu' => 'uwig',

    // Message 
    'MsgCheckPage' => 'Vous n\'êtes pas autorisé <br/>à accéder à cette page.',
    'AucunInfosTrouve' => '&nbsp;Aucun enregistrement trouvé.',
    'AucunInfosTrouvesite' => '&nbsp;Aucune information trouvée sur ',
    'titre_delete' => 'Suppression',
    'titre_transmettre' => 'Transmettre cette information',
    'titre_publier' => 'Publier cette information',
    'titre_Arreterdepublier' => 'Arrêter la publication de cette information',
    'infos_error' => 'Une erreur est survenue lors du chargement de l\'enregistrement de l\'utilisateur. Veuillez contactez l\'administrateur',
    'infos_add' => 'Enregistrement effectué avec succès.',
    'infos_update' => 'Modification effectuée avec succès.',
    'infos_delete' => 'Un élément supprimé avec succès',
    'infos_trans' => 'Un élément transmis avec succès',
    'infos_go' => 'Publication effetuée avec succès',
    'infos_stop' => 'Publication arrêtée avec succès',
    'MsgCheckPage' => 'Vous n\'êtes pas autorisé <br/>à accéder à cette page.',
    'MsgCheckApp' => 'Votre compte est désactivité. Veuillez contactez l\'administrateur.',

    //CSS
    //#212529 : Noire 
    'colorTemplate' => '#164d03',
    'bar_page_stylePdf' => ' <style>
        .footer {width: 100%; font-size:10px; text-align: center;position: fixed;}
        .footer {bottom: 0px;}
        .pagenum:before {content: counter(page);}
    </style> ',

    'stylePdf' => ' <style>
        .footer {width: 100%;text-align: right;position: fixed;}
        .footer {bottom: 0px;}
        .pagenum:before {content: counter(page);}

        .td{padding: 3px 3px 3px 3px; }
        .table {border-collapse:collapse;}
        .th,.td {border:1px solid black;}
    </style> ',
    'signaturePdf' => 'Imprimé par '.Config('app.name').' Page ',
    'styleLignePdf' => '#b4b4a4',
];
