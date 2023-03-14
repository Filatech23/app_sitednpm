<meta name='csrf-token' content='{{csrf_token()}}'>

<div class="modal-content">
	<div class="modal-header card-header"><h5 class="modal-title" id="varyingcontentModalLabel"><i class="{{$icone}}"></i>  {{$titre}}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
		<div class="modal-body"><strong><div class="msgAction"></div></strong>
			<form id="formaActionUp" class="needs-validation"  method="post" novalidate enctype='multipart/form-data'>
				@csrf()
				@method('PATCH')
				{!! Form::hidden('id_doc',$item->id_doc,['id'=>'id_doc']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="nom_doc" class="form-label">{!!trans('data.nom_doc')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::text('nom_doc',$item->nom_doc,["id"=>"nom_doc","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Nom" ]) !!}
							<span class="text-danger" id="nom_docError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="Fichier" class="form-label">{!!trans('data.Fichier').' '.$item->Fichier !!} <strong style='color: red;'> *</strong></label>
							<input class="form-control" type="file" id="Fichier" name="Fichier" <?php echo isset($item->Fichier) ? '' : 'required'; ?> >
							<span class="text-danger" id="FichierError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="telecharger_doc" class="form-label">{!!trans('data.telecharger_doc')!!} <strong style='color: red;'> *</strong></label>
							<?php $addtelecharger_doc = array('' => 'Choisir', 'Oui' => 'Oui', 'Non' => 'Non');?>
							{!! Form::select('telecharger_doc',$addtelecharger_doc ,$item->telecharger_doc,["id"=>"telecharger_doc","class"=>"form-select allselect"]) !!}
							<span class="text-danger" id="telecharger_docError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="menusite_id" class="form-label">{!!trans('data.menusite_id')!!} <strong style='color: red;'> *</strong></label>
							<?php $addUse = array(''=>'S&eacute;lectionnez un &eacute;l&eacute;ment'); $listmenusite_id = $addUse + $listmenusite_id->toArray();?>
							{!! Form::select('menusite_id',$listmenusite_id ,$item->menusite_id,["id"=>"menusite_id","class"=>"form-select allselect"]) !!}
							<span class="text-danger" id="menusite_idError"></span>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-12">
							<label for="autre_inf" class="form-label">{!!trans('data.autre_inf')!!} </label>
							{!! Form::textarea('autre_inf',$item->autre_inf,["id"=>"autre_inf","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Autres infors." , 'rows'=>'4'  ]) !!}
							<span class="text-danger" id="autre_infError"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark waves-effect waves-light" data-bs-dismiss="modal">Femer</button>
					@if(in_array('update_document',session('InfosAction')))
						<button id="validerup" type="button"  class="btn btn-primary btn-label right btn-load" onclick="UpdateAction();">
							<span class="d-flex align-items-center"><span class="flex-grow-1 me-2">Modifier</span><span class="flex-shrink-0" role="status"></span></span>
							<i class="ri-add-line label-icon align-middle fs-16 ms-2"></i>
						</button>
					@endif
				</div>
			</form>
		</div>
	</div>

<script type="text/javascript"> $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}}); </script>

<script type="text/javascript">
	function UpdateAction(){

		$('#validerup').attr("disabled",!0);
		$('#validerup .flex-shrink-0').addClass("spinner-border");
		$("div.msgAction").html('').hide(200);
		$('#nom_docError').addClass('d-none');
		$('#FichierError').addClass('d-none');
		$('#telecharger_docError').addClass('d-none');
		$('#menusite_idError').addClass('d-none');
		$('#autre_infError').addClass('d-none');
		var formup = $('#formaActionUp')[0];
		var id_doc = $('#id_doc').val();
		var data = new FormData(formup);
		let url_ = "{{route('docu.update',':id')}}";
		url_ = url_.replace(':id',id_doc);

		$.ajax({
			type: 'POST',url: url_,
			enctype:'multipart/form-data',data: data,processData: false,contentType: false,
			success: function(data) {
				$('#validerup').attr("disabled",!1);
				$('#validerup .flex-shrink-0').removeClass("spinner-border");
				if(data.response==1){
					$("div.msgAction").html('<div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert"><i class="ri-notification-off-line me-3 align-middle"></i> <strong>Infos </strong> Enregistrement r&eacute;ussi. </div>').show(200);
					window.location.reload();
				}else if(data.response==0){
					$("div.msgAction").html('<div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert"><i class="ri-notification-off-line me-3 align-middle"></i> <strong>Echec de l\'enregistrement</strong> '+data.message+'</div>').show(200);
				}else{
					$.each(data.response, function(Key, value){
						var ErrorID = '#'+Key+'Error';
						$(ErrorID).removeClass('d-none');
						$(ErrorID).text(value);
					})
				}
			},error: function(data) {}
		});
	}
</script>

