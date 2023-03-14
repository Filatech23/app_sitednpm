<title>{{Config('app.name') }} | Liste des activites</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
{!!trans('data.stylePdf')!!} 
<div class="footer"><i>{!!trans('data.signaturePdf')!!} <span class="pagenum"></span> </i></div>

@if(count($list) != 0)
	<div><h3 style="text-align:center;">Liste des activites<br>
		@if(!empty($_GET['query']))
			Recherche : {{$_GET['query']}}<br>
		@endif
	</h3></div>

	<table class="table" style="font-size:15px; width:100%;">
		<tr>
			<th class="th" >{!!trans('data.id_activite')!!}</th>
			<th class="th" >{!!trans('data.titre_act')!!}</th>
			<th class="th" >{!!trans('data.descr_act')!!}</th>
			<th class="th" >{!!trans('data.img_act')!!}</th>
			<th class="th" >{!!trans('data.menusite_id')!!}</th>
			<th class="th" >{!!trans('data.init_id')!!}</th>
			<th class="th" >{!!trans('data.etat_act')!!}</th>
			<th class="th" >{!!trans('data.motif_act')!!}</th>
		</tr>
		<tbody>{{$i = 1}}
			@foreach($list as $listgiwu)
				<tr style="background-color : <?php if ($i % 2 == 0) {echo '#ffffff';$i++;}else{echo trans("data.styleLignePdf");$i++;} ?>;">
					<td class="td">{{$listgiwu->id_activite}}</td>
					<td class="td">{{$listgiwu->titre_act}}</td>
					<td class="td">{{$listgiwu->descr_act}}</td>
					<td class="td">{!! $listgiwu->img_act !!}</td>
					<td class="td">{{isset($listgiwu->menusite) ? $listgiwu->menusite->libelle_menu : trans('data.not_found')}}</td>
					<td class="td">{{isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found')}}</td>
					<td class='text-center td'>
						@if($listgiwu->etat_act == 'e') <span class='badge bg-warning'>En attente</a>
						@elseif($listgiwu->etat_act == 't') <span class='badge bg-danger'>En attente</a>
						@elseif($listgiwu->etat_act == 'p') <span class='badge bg-secondary'>Publier</a>
						@endif
					</td>
					<td class="td">{{$listgiwu->motif_act}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div><strong>Info! </strong> {!! trans('data.AucunInfosTrouve')!!} </div>
@endif
