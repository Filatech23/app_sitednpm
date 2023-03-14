

<meta name='csrf-token' content='{{csrf_token()}}'>
<div class="modal-content">
	<div class="modal-header card-header"><h5 class="modal-title" id="varyingcontentModalLabel"><i class="{{$icone}}"></i>  {{$titre}}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
		<div class="modal-body"><strong><div class="msgAction"></div></strong>
			<form id="formAction" class="needs-validation"  method="post" novalidate enctype='multipart/form-data'>
				@csrf()
				<div class="row">
					<div class="col-md-12">
						<div class="mb-3">
							<label for="titre_act" class="form-label">{!!trans('data.titre_act')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::text('titre_act','',["id"=>"titre_act","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Titre" ]) !!}
							<span class="text-danger" id="titre_actError"></span>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label for="descr_act" class="form-label">{!!trans('data.descr_act')!!} </label>
							<textarea class="form-control" id="descr_act" name="descr_act" ></textarea>
							<span class="text-danger" id="descr_actError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="img_act" class="form-label">{!!trans('data.img_act')!!} </label>
							<input class="form-control" type="file" id="img_act" name="img_act" >
							<span class="text-danger" id="img_actError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="menusite_id" class="form-label">{!!trans('data.menusite_id')!!} <strong style='color: red;'> *</strong></label>
							<?php $addUse = array(''=>'S&eacute;lectionnez un &eacute;l&eacute;ment'); $listmenusite_id = $addUse + $listmenusite_id->toArray();?>
							{!! Form::select('menusite_id',$listmenusite_id ,session('menusite_idSess'),["id"=>"menusite_id","class"=>"form-select allselect"]) !!}
							<span class="text-danger" id="menusite_idError"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark waves-effect waves-light" data-bs-dismiss="modal">Femer</button>
					@if(in_array('add_activite',session('InfosAction')))
						<button id="valider" type="button"  class="btn btn-primary btn-label right btn-load" onclick="addAction();">
							<span class="d-flex align-items-center"><span class="flex-grow-1 me-2">Ajouter</span><span class="flex-shrink-0" role="status"></span></span>
							<i class="ri-add-line label-icon align-middle fs-16 ms-2"></i>
						</button>
					@endif
				</div>
			</form>
		</div>
	</div>

<script type="text/javascript"> $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}}); </script>


<script type="text/javascript">
	// CKEDITOR.replace('descr_act');
	$(document).ready(function() {
        $('#descr_act').summernote();
    })
</script>
<script type="text/javascript">
	function addAction(){
		
		$('#valider').attr("disabled",!0);
		$('#valider .flex-shrink-0').addClass("spinner-border");
		$("div.msgAction").html('').hide(200);
		$('#titre_actError').addClass('d-none');
		$('#descr_actError').addClass('d-none');
		$('#img_actError').addClass('d-none');
		$('#menusite_idError').addClass('d-none');
		var form = $('#formAction')[0];
		var data = new FormData(form);
		$.ajax({
			type: 'POST',url: '{{ url("/activite/")}}',
			enctype:'multipart/form-data',data: data,processData: false,contentType: false,
			success: function(data) {
				$('#valider').attr("disabled",!1);
				$('#valider .flex-shrink-0').removeClass("spinner-border");
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
