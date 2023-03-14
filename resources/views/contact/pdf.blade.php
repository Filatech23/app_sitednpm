<title>{{Config('app.name') }} | Liste des contacts</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
{!!trans('data.stylePdf')!!} 
<div class="footer"><i>{!!trans('data.signaturePdf')!!} <span class="pagenum"></span> </i></div>

@if(count($list) != 0)
	<div><h3 style="text-align:center;">Liste des contacts<br>
		@if(!empty($_GET['query']))
			Recherche : {{$_GET['query']}}<br>
		@endif
	</h3></div>

	<table class="table" style="font-size:15px; width:100%;">
		<tr>
			<th class="th" >{!!trans('data.id_cont')!!}</th>
			<th class="th" >{!!trans('data.nom_prenom_cont')!!}</th>
			<th class="th" >{!!trans('data.mail_cont')!!}</th>
			<th class="th" >{!!trans('data.sujet_cont')!!}</th>
			<th class="th" >{!!trans('data.msg_cont')!!}</th>
			<th class="th" >{!!trans('data.statut_cont')!!}</th>
			<th class="th" >{!!trans('data.traite_par')!!}</th>
		</tr>
		<tbody>{{$i = 1}}
			@foreach($list as $listgiwu)
				<tr style="background-color : <?php if ($i % 2 == 0) {echo '#ffffff';$i++;}else{echo trans("data.styleLignePdf");$i++;} ?>;">
					<td class="td">{{$listgiwu->id_cont}}</td>
					<td class="td">{{$listgiwu->nom_prenom_cont}}</td>
					<td class="td">{{$listgiwu->mail_cont}}</td>
					<td class="td">{{$listgiwu->sujet_cont}}</td>
					<td class="td">{{$listgiwu->msg_cont}}</td>
					<td class="td">{{trans('entite.traite')[$listgiwu->statut_cont]}}</td>
					<td class="td">{{isset($listgiwu->users_g) ? $listgiwu->users_g->name." ".$listgiwu->users_g->prenom : trans('data.not_found')}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	<div><strong>Info! </strong> {!! trans('data.AucunInfosTrouve')!!} </div>
@endif
