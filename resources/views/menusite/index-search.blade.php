<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@if(count($list) != 0)
	@if(in_array('update_menusite',session('InfosAction')) || in_array('delete_menusite',session('InfosAction')) )
		@if(in_array('update_menusite',session('InfosAction')))
			<button type='button' class='btn btn-success btn-label right waves-light' id='btn-modifier'><i class='ri-check-double-line label-icon align-middle fs-16 ms-2'></i> Modifier</button>
		@endif
		@if(in_array('delete_menusite',session('InfosAction')))
			<button type='button' class='btn btn-danger btn-label right waves-light' id='btn-supprimer'><i class='ri-delete-bin-6-line label-icon align-middle fs-16 ms-2'></i> Supprimer</button>
		@endif
		@if(in_array('transmettre_menusite',session('InfosAction')))
			<button type='button' class='btn btn-warning btn-label right waves-light' data-id='trans' id='btn-transmettre'><i class=' ri-share-forward-line label-icon align-middle fs-16 ms-2'></i> Transmettre</button>
		@endif
		@if(in_array('valider_menusite',session('InfosAction')))
			<button type='button' class='btn btn-secondary btn-label right waves-light' id='btn-go' data-id='go'><i class='ri-send-plane-fill label-icon align-middle fs-16 ms-2'></i> Publier</button>
			<button type='button' class='btn btn-danger btn-label right waves-light d-none' id='btn-stop' data-id='stop'><i class='ri-stop-mini-fill label-icon align-middle fs-16 ms-2 '></i> Arr&ecirc;ter de publier</button>
			<!-- <button type='button' class='btn btn-primary btn-label right waves-light d-none' id='btn-return'><i class='ri-arrow-go-back-line label-icon align-middle fs-16 ms-2'></i> Retourner pour correction</button> -->
		@endif
	@endif
	<table class="table table-striped table-bordered table-nowrap mt-4">
		<thead><tr>
			<th scope='col'></th>
			<th scope="col" >{!!trans('data.libelle_menu')!!}</th>
			<th scope="col" class="text-center">{!!trans('data.ordre_menu')!!}</th>
			<th scope="col" class="text-center">{!!trans('data.id_parent')!!}</th>
			<th scope="col" >{!!trans('data.type_affiche')!!}</th>
			<th scope="col" class="text-center">{!!trans('data.etat_menu')!!}</th>
			<!-- <th scope="col" >{!!trans('data.motif_menu')!!}</th> -->
			@if(in_array('init_giwu',session('InfosAction')))
			<!-- <th scope="col" class="text-center">{!!trans('data.init_id')!!}</th> -->
			@endif
		</tr></thead>
		<tbody>
			@foreach($list as $listgiwu)
				<tr>
					<td class='text-center'><input class='form-check-input checkradio' data-id='{{$listgiwu->id_menusite}}' data-etat_menu='{{$listgiwu->etat_menu}}' type='radio' name='formradiocolor9' id='formradioRight13'></td>
					<td>{!! $listgiwu->libelle_menu !!}</td>
					<td style ='text-align:right' >{{strrev(wordwrap(strrev(intval($listgiwu->ordre_menu)), 3, ' ', true))}}</td>
					<td>{!! isset($listgiwu->menusite) ? $listgiwu->menusite->libelle_menu : 'Principal' !!}</td>
					<td>{!! trans('entite.type_affiche')[$listgiwu->type_affiche] !!}</td>
					<td class='text-center'>
						@if($listgiwu->etat_menu == 'e') <span class='badge bg-warning'>En attente</a>
						@elseif($listgiwu->etat_menu == 't') <span class='badge bg-danger'>En attente</a>
						@elseif($listgiwu->etat_menu == 'p') <span class='badge bg-secondary'>Publier</a>
						@endif
					</td>
					<!-- <td>{!! $listgiwu->motif_menu !!}</td> -->
				@if(in_array('init_giwu',session('InfosAction')))
					<!-- <td>{!! isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found') !!}</td> -->
				@endif
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $list->appends(['query'=>(isset($_GET['query'])?$_GET['query']:'') ])->links() !!}
@else
	<div Class="alert alert-info"><strong>Info! </strong> {!!trans('data.AucunInfosTrouve')!!} </div>
@endif
