<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
@if(count($list) != 0)
	@if(in_array('update_contact',session('InfosAction')) || in_array('delete_contact',session('InfosAction')) )
		@if(in_array('update_contact',session('InfosAction')))
			<button type='button' class='btn btn-success btn-label right waves-light' id='btn-modifier'><i class='ri-check-double-line label-icon align-middle fs-16 ms-2'></i> Modifier</button>
		@endif
		@if(in_array('delete_contact',session('InfosAction')))
			<button type='button' class='btn btn-danger btn-label right waves-light' id='btn-supprimer'><i class='ri-delete-bin-6-line label-icon align-middle fs-16 ms-2'></i> Supprimer</button>
		@endif
	@endif
	<table class="table table-striped table-bordered table-nowrap mt-4">
		<thead><tr>
			<th scope='col'></th>
			<th scope="col" >{!!trans('data.nom_prenom_cont')!!}</th>
			<th scope="col" >{!!trans('data.mail_cont')!!}</th>
			<th scope="col" >{!!trans('data.sujet_cont')!!}</th>
			<th scope="col" >{!!trans('data.msg_cont')!!}</th>
			<th scope="col" >{!!trans('data.statut_cont')!!}</th>
			@if(in_array('init_giwu',session('InfosAction')))
			<th scope="col" class="text-center">{!!trans('data.traite_par')!!}</th>
			@endif
		</tr></thead>
		<tbody>
			@foreach($list as $listgiwu)
				<tr>
					<td class='text-center'><input class='form-check-input checkradio' data-id='{{$listgiwu->id_cont}}'  type='radio' name='formradiocolor9' id='formradioRight13'></td>
					<td>{!! $listgiwu->nom_prenom_cont !!}</td>
					<td>{!! $listgiwu->mail_cont !!}</td>
					<td>{!! $listgiwu->sujet_cont !!}</td>
					<td> @if(strlen($listgiwu->msg_cont) > 50)
						{!! substr($listgiwu->msg_cont, 0, 50) !!}...
						@else  {!! $listgiwu->msg_cont !!} 
						@endif </td>
					<td class="text-center">
                        @if($listgiwu->statut_cont == 't')
							<span class="badge bg-success">
								{!! trans('entite.traite')[$listgiwu->statut_cont] !!}
							</span> 
						@else 
							<span class="badge bg-danger">
								{!! trans('entite.traite')[$listgiwu->statut_cont] !!}
							</span> 
						@endif
                    </td>
				@if(in_array('init_giwu',session('InfosAction')))
					<td>{!! isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found') !!}</td>
				@endif
				</tr>
			@endforeach
		</tbody>
	</table>
	
	{!! $list->appends(['query'=>(isset($_GET['query'])?$_GET['query']:'') ])->links() !!}
@else
	<div Class="alert alert-info"><strong>Info! </strong> {!!trans('data.AucunInfosTrouve')!!} </div>
@endif
