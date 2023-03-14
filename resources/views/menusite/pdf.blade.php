<title>{{Config('app.name') }} | Menus du site</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
{!!trans('data.stylePdf')!!} 
<div class="footer"><i>{!!trans('data.signaturePdf')!!} <span class="pagenum"></span> </i></div>

@if(count($list) != 0)
	<div><h3 style="text-align:center;">Menus du site<br>
		@if(!empty($_GET['query']))
			Recherche : {{$_GET['query']}}<br>
		@endif
	</h3></div>

	<table class="table" style="font-size:15px; width:100%;">
		<tr>
			<th class="th" >{!!trans('data.id_menusite')!!}</th>
			<th class="th" >{!!trans('data.libelle_menu')!!}</th>
			<th class="th" >{!!trans('data.ordre_menu')!!}</th>
			<th class="th" >{!!trans('data.id_parent')!!}</th>
			<th class="th" >{!!trans('data.route_menu')!!}</th>
			<th class="th" >{!!trans('data.etat_menu')!!}</th>
			<th class="th" >{!!trans('data.motif_menu')!!}</th>
			<th class="th" >{!!trans('data.init_id')!!}</th>
		</tr>
		<tbody>{{$i = 1}}
			@foreach($list as $listgiwu)
				<tr style="background-color : <?php if ($i % 2 == 0) {echo '#ffffff';$i++;}else{echo trans("data.styleLignePdf");$i++;} ?>;">
					<td class="td">{{$listgiwu->id_menusite}}</td>
					<td class="td">{{$listgiwu->libelle_menu}}</td>
					<td class="td" >{{strrev(wordwrap(strrev(intval($listgiwu->ordre_menu)), 3, ' ', true))}}</td>
					<td class="td">{{isset($listgiwu->menusite) ? $listgiwu->menusite->libelle_menu : trans('data.not_found')}}</td>
					<td class="td">{{$listgiwu->route_menu}}</td>
					<td class='text-center td'>
						@if($listgiwu->etat_menu == 'e') <span class='badge bg-warning'>En attente</a>
						@elseif($listgiwu->etat_menu == 't') <span class='badge bg-danger'>En attente</a>
						@elseif($listgiwu->etat_menu == 'p') <span class='badge bg-secondary'>Publier</a>
						@endif
					</td>
					<td class="td">{{$listgiwu->motif_menu}}</td>
					<td class="td">{{isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found')}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div><strong>Info! </strong> {!! trans('data.AucunInfosTrouve')!!} </div>
@endif
