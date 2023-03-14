<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@if(count($list) != 0)
	@if(in_array('update_document',session('InfosAction')) || in_array('delete_document',session('InfosAction')) )
		@if(in_array('update_document',session('InfosAction')))
			<button type='button' class='btn btn-success btn-label right waves-light' id='btn-modifier'><i class='ri-check-double-line label-icon align-middle fs-16 ms-2'></i> Modifier</button>
		@endif
		@if(in_array('delete_document',session('InfosAction')))
			<button type='button' class='btn btn-danger btn-label right waves-light' id='btn-supprimer'><i class='ri-delete-bin-6-line label-icon align-middle fs-16 ms-2'></i> Supprimer</button>
		@endif
		@if(in_array('transmettre_document',session('InfosAction')))
			<button type='button' class='btn btn-warning btn-label right waves-light' data-id='trans' id='btn-transmettre'><i class=' ri-share-forward-line label-icon align-middle fs-16 ms-2'></i> Transmettre</button>
		@endif
		@if(in_array('valider_document',session('InfosAction')))
			<button type='button' class='btn btn-secondary btn-label right waves-light' id='btn-go' data-id='go'><i class='ri-send-plane-fill label-icon align-middle fs-16 ms-2'></i> Publier</button>
			<button type='button' class='btn btn-danger btn-label right waves-light d-none' id='btn-stop' data-id='stop'><i class='ri-stop-mini-fill label-icon align-middle fs-16 ms-2 '></i> Arr&ecirc;ter de publier</button>
			<button type='button' class='btn btn-primary btn-label right waves-light d-none' id='btn-return'><i class='ri-arrow-go-back-line label-icon align-middle fs-16 ms-2'></i> Retourner pour correction</button>
		@endif
	@endif
	<table class="table table-striped table-bordered table-nowrap mt-4">
		<thead><tr>
			<th scope='col'></th>
			<th scope="col" >{!!trans('data.nom_doc')!!}</th>
			<th scope="col" >{!!trans('data.autre_inf')!!}</th>
			<th scope="col" class="text-center">{!!trans('data.etat_doc')!!}</th>
			<th scope="col" class="text-center">{!!trans('data.Fichier')!!}</th>
			<!-- @if(in_array('init_giwu',session('InfosAction')))
			<th scope="col" class="text-center">{!!trans('data.init_id')!!}</th>
			@endif -->
			<th scope="col" class="text-center">{!!trans('data.menusite_id')!!}</th>
			<th scope="col" >{!!trans('data.telecharger_doc')!!}</th>
			<th scope="col" >{!!trans('data.motif_doc')!!}</th>
		</tr></thead>
		<tbody>
			@foreach($list as $listgiwu)
				<tr>
					<td class='text-center'><input class='form-check-input checkradio' data-id='{{$listgiwu->id_doc}}' data-etat_doc='{{$listgiwu->etat_doc}}' type='radio' name='formradiocolor9' id='formradioRight13'></td>
					<td>{!! $listgiwu->nom_doc !!}</td>
					<td> @if(strlen($listgiwu->autre_inf) > 50)
						{!! substr($listgiwu->autre_inf, 0, 50) !!}...
						@else  {!! $listgiwu->autre_inf !!} 
						@endif </td>
					<td class='text-center'>
						@if($listgiwu->etat_doc == 'e') <span class='badge bg-warning'>En attente</a>
						@elseif($listgiwu->etat_doc == 't') <span class='badge bg-danger'>En attente</a>
						@elseif($listgiwu->etat_doc == 'p') <span class='badge bg-secondary'>Publier</a>
						@endif
					</td>
					<td class="text-center">
						@if($listgiwu->Fichier)
							<a href='{{"assets/docs/".$listgiwu->Fichier}}' title="{!!$listgiwu->Fichier!!}" target="_blank" class="badge bg-success">Ouvrir</a>
						@else <span class="badge bg-danger">Aucun</a>  @endif
					</td>
					<!-- @if(in_array('init_giwu',session('InfosAction')))
						<td>{!! isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found') !!}</td>
					@endif -->
					<td>{!! isset($listgiwu->menusite) ? $listgiwu->menusite->libelle_menu : trans('data.not_found') !!}</td>
					<td>{!! $listgiwu->telecharger_doc !!}</td>
					<td> @if(strlen($listgiwu->motif_doc) > 50)
						{!! substr($listgiwu->motif_doc, 0, 50) !!}...
						@else  {!! $listgiwu->motif_doc !!} 
						@endif </td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $list->appends(['query'=>(isset($_GET['query'])?$_GET['query']:'') ])->links() !!}
@else
	<div Class="alert alert-info"><strong>Info! </strong> {!!trans('data.AucunInfosTrouve')!!} </div>
@endif
