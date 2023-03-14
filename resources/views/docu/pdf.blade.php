<title>{{Config('app.name') }} | Liste des documents</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
{!!trans('data.stylePdf')!!} 
<div class="footer"><i>{!!trans('data.signaturePdf')!!} <span class="pagenum"></span> </i></div>

@if(count($list) != 0)
	<div><h3 style="text-align:center;">Liste des documents<br>
		@if(!empty($_GET['query']))
			Recherche : {{$_GET['query']}}<br>
		@endif
	</h3></div>

	<table class="table" style="font-size:15px; width:100%;">
		<tr>
			<th class="th" >{!!trans('data.nom_doc')!!}</th>
			<th class="th" >{!!trans('data.autre_inf')!!}</th>
			<th class="th" >{!!trans('data.etat_doc')!!}</th>
			<th class="th" >{!!trans('data.Fichier')!!}</th>
			<th class="th" >{!!trans('data.init_id')!!}</th>
			<th class="th" >{!!trans('data.menusite_id')!!}</th>
			<th class="th" >{!!trans('data.telecharger_doc')!!}</th>
			<th class="th" >{!!trans('data.motif_doc')!!}</th>
		</tr>
		<tbody>{{$i = 1}}
			@foreach($list as $listgiwu)
				<tr style="background-color : <?php if ($i % 2 == 0) {echo '#ffffff';$i++;}else{echo trans("data.styleLignePdf");$i++;} ?>;">
					<td class="td">{{$listgiwu->nom_doc}}</td>
					<td class="td">{{$listgiwu->autre_inf}}</td>
					<td class='text-center td'>
						@if($listgiwu->etat_doc == 'e') <span class='badge bg-warning'>En attente</a>
						@elseif($listgiwu->etat_doc == 't') <span class='badge bg-danger'>En attente</a>
						@elseif($listgiwu->etat_doc == 'p') <span class='badge bg-secondary'>Publier</a>
						@endif
					</td>
					<td class="td">{!! $listgiwu->Fichier !!}</td>
					<td class="td">{{isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found')}}</td>
					<td class="td">{{isset($listgiwu->menusite) ? $listgiwu->menusite->libelle_menu : trans('data.not_found')}}</td>
					<td class="td">{{$listgiwu->telecharger_doc}}</td>
					<td class="td">{{$listgiwu->motif_doc}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div><strong>Info! </strong> {!! trans('data.AucunInfosTrouve')!!} </div>
@endif
