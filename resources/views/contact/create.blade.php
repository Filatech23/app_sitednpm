<meta name='csrf-token' content='{{csrf_token()}}'>

<div class="modal-content">
	<div class="modal-header card-header"><h5 class="modal-title" id="varyingcontentModalLabel"><i class="{{$icone}}"></i>  {{$titre}}</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
		<div class="modal-body"><strong><div class="msgAction"></div></strong>
			<form id="formAction" class="needs-validation"  method="post" novalidate >
				@csrf()
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="nom_prenom_cont" class="form-label">{!!trans('data.nom_prenom_cont')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::text('nom_prenom_cont','',["id"=>"nom_prenom_cont","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Nom" ]) !!}
							<span class="text-danger" id="nom_prenom_contError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="mail_cont" class="form-label">{!!trans('data.mail_cont')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::text('mail_cont','',["id"=>"mail_cont","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer E-mail" ]) !!}
							<span class="text-danger" id="mail_contError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="sujet_cont" class="form-label">{!!trans('data.sujet_cont')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::text('sujet_cont','',["id"=>"sujet_cont","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Sujet" ]) !!}
							<span class="text-danger" id="sujet_contError"></span>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-12">
							<label for="msg_cont" class="form-label">{!!trans('data.msg_cont')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::textarea('msg_cont','',["id"=>"msg_cont","class"=>"form-control" ,'autocomplete'=>'off' ,'placeholder'=>"Entrer Message" , 'rows'=>'4'  ]) !!}
							<span class="text-danger" id="msg_contError"></span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="statut_cont" class="form-label">{!!trans('data.statut_cont')!!} <strong style='color: red;'> *</strong></label>
							{!! Form::select('statut_cont',trans('entite.traite') ,null,["id"=>"statut_cont","class"=>"form-select allselect"]) !!}
							<span class="text-danger" id="statut_contError"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-dark waves-effect waves-light" data-bs-dismiss="modal">Femer</button>
					@if(in_array('add_contact',session('InfosAction')))
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
	function addAction(){

		$('#valider').attr("disabled",!0);
		$('#valider .flex-shrink-0').addClass("spinner-border");
		$("div.msgAction").html('').hide(200);
		$('#nom_prenom_contError').addClass('d-none');
		$('#mail_contError').addClass('d-none');
		$('#sujet_contError').addClass('d-none');
		$('#msg_contError').addClass('d-none');
		$('#statut_contError').addClass('d-none');
		var form = $('#formAction')[0];
		var data = new FormData(form);
		$.ajax({
			type: 'POST',url: '{{ url("/contact/")}}',
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

