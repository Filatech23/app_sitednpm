<meta name='csrf-token' content='{{csrf_token()}}'>

<div class="modal-content">
	<div class="modal-header card-header"><h5 class="modal-title" id="varyingcontentModalLabel"><i class="{{$icone}}"></i>  {{$titre}}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
		<div class="modal-body"><strong><div class="msgAction"></div></strong>
			<form id="formaActionUp" class="needs-validation"  method="post" novalidate >
				@csrf()
				@method('PATCH')
				{!! Form::hidden('id_menusite',$item->id_menusite,['id'=>'id_menusite']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="libelle_menu" class="form-label">{!!trans('data.libelle_menu')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::text('libelle_menu',$item->libelle_menu,["id"=>"libelle_menu","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Menu" ]) !!}
							<span class="text-danger" id="libelle_menuError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="ordre_menu" class="form-label">{!!trans('data.ordre_menu')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::number('ordre_menu',$item->ordre_menu,["id"=>"ordre_menu","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Ordre" ]) !!}
							<span class="text-danger" id="ordre_menuError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="id_parent" class="form-label">{!!trans('data.id_parent')!!} </label>
							<?php $addUse = array(''=>'S&eacute;lectionnez un &eacute;l&eacute;ment'); $listid_parent = $addUse + $listid_parent->toArray();?>
							{!! Form::select('id_parent',$listid_parent ,$item->id_parent,["id"=>"id_parent","class"=>"form-select allselect"]) !!}
							<span class="text-danger" id="id_parentError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="type_affiche" class="form-label">{!!trans('data.type_affiche')!!} </label>
							{!! Form::select('type_affiche',trans('entite.type_affiche') ,$item->type_affiche,["id"=>"type_affiche","class"=>"form-select allselect"]) !!}
							<span class="text-danger" id="type_afficheError"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark waves-effect waves-light" data-bs-dismiss="modal">Femer</button>
					@if(in_array('update_menusite',session('InfosAction')))
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
		$('#libelle_menuError').addClass('d-none');
		$('#ordre_menuError').addClass('d-none');
		$('#id_parentError').addClass('d-none');
		$('#route_menuError').addClass('d-none');
		var formup = $('#formaActionUp')[0];
		var id_menusite = $('#id_menusite').val();
		var data = new FormData(formup);
		let url_ = "{{route('menusite.update',':id')}}";
		url_ = url_.replace(':id',id_menusite);

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

