<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@if(count($list) != 0)
	@if(in_array('update_activite',session('InfosAction')) || in_array('delete_activite',session('InfosAction')) )
		@if(in_array('update_activite',session('InfosAction')))
			<button type='button' class='btn btn-success btn-label right waves-light' id='btn-modifier'><i class='ri-check-double-line label-icon align-middle fs-16 ms-2'></i> Modifier</button>
		@endif
		@if(in_array('delete_activite',session('InfosAction')))
			<button type='button' class='btn btn-danger btn-label right waves-light' id='btn-supprimer'><i class='ri-delete-bin-6-line label-icon align-middle fs-16 ms-2'></i> Supprimer</button>
		@endif
		@if(in_array('transmettre_activite',session('InfosAction')))
			<button type='button' class='btn btn-warning btn-label right waves-light' data-id='trans' id='btn-transmettre'><i class=' ri-share-forward-line label-icon align-middle fs-16 ms-2'></i> Transmettre</button>
		@endif
		@if(in_array('valider_activite',session('InfosAction')))
			<button type='button' class='btn btn-secondary btn-label right waves-light' id='btn-go' data-id='go'><i class='ri-send-plane-fill label-icon align-middle fs-16 ms-2'></i> Publier</button>
			<button type='button' class='btn btn-danger btn-label right waves-light d-none' id='btn-stop' data-id='stop'><i class='ri-stop-mini-fill label-icon align-middle fs-16 ms-2 '></i> Arr&ecirc;ter de publier</button>
			<button type='button' class='btn btn-primary btn-label right waves-light d-none' id='btn-return'><i class='ri-arrow-go-back-line label-icon align-middle fs-16 ms-2'></i> Retourner pour correction</button>
		@endif
	@endif
	<table class="table table-striped table-bordered table-nowrap mt-4">
		<thead><tr>
			<th scope='col'></th>
			<th scope="col" >{!!trans('data.titre_act')!!}</th>
			<!-- <th scope="col" >{!!trans('data.descr_act')!!}</th> -->
			<th scope="col" class="text-center">{!!trans('data.img_act')!!}</th>
			<th scope="col" class="text-center">{!!trans('data.menusite_id')!!}</th>
			@if(in_array('init_giwu',session('InfosAction')))
			<th scope="col" class="text-center">{!!trans('data.init_id')!!}</th>
			@endif
			<th scope="col" class="text-center">{!!trans('data.etat_act')!!}</th>
			<th scope="col" >{!!trans('data.motif_act')!!}</th>
		</tr></thead>
		<tbody>
			@foreach($list as $listgiwu)
				<tr>
					<td class='text-center'><input class='form-check-input checkradio' data-id='{{$listgiwu->id_activite}}' data-etat_act='{{$listgiwu->etat_act}}' type='radio' name='formradiocolor9' id='formradioRight13'></td>
					<td title="{!!$listgiwu->titre_act!!}">
						@if(strlen($listgiwu->titre_act) > 40)
							{!! substr($listgiwu->titre_act, 0, 40) !!}...
							@else  {!! $listgiwu->titre_act !!} 
							@endif 
					</td>
					<!-- <td> @if(strlen($listgiwu->descr_act) > 50)
						{!! substr($listgiwu->descr_act, 0, 50) !!}...
						@else  {!! $listgiwu->descr_act !!} 
						@endif 
					</td> -->
					<td class="text-center">
						@if($listgiwu->img_act) 
							<img src='{{"assets/docs/".$listgiwu->img_act}}' alt="" class="rounded avatar-lg">
						@else <span class="badge bg-danger">Aucun</span>  @endif
					</td>
					<td>{!! isset($listgiwu->menusite) ? $listgiwu->menusite->libelle_menu : trans('data.not_found') !!}</td>
					@if(in_array('init_giwu',session('InfosAction')))
						<td>{!! isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found') !!}</td>
					@endif
					<td class='text-center'>
						@if($listgiwu->etat_act == 'e') <span class='badge bg-warning'>En attente</a>
						@elseif($listgiwu->etat_act == 't') <span class='badge bg-danger'>En attente</a>
						@elseif($listgiwu->etat_act == 'p') <span class='badge bg-secondary'>Publier</a>
						@endif
					</td>
					<td> @if(strlen($listgiwu->motif_act) > 50)
						{!! substr($listgiwu->motif_act, 0, 50) !!}...
						@else  {!! $listgiwu->motif_act !!} 
						@endif 
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $list->appends(['query'=>(isset($_GET['query'])?$_GET['query']:'') ])->links() !!}
@else
	<div Class="alert alert-info"><strong>Info! </strong> {!!trans('data.AucunInfosTrouve')!!} </div>
@endif
