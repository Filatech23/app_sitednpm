
<meta name="csrf-token" content="{{csrf_token()}}">

<div class="modal-content">
	<div class="modal-header card-header">
		<h5 class="modal-title" id="varyingcontentModalLabel">Motif</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">
		<strong><div class="msgAction"></div></strong>
		<form id="formAction" class="needs-validation" novalidate>
			{!! Form::hidden('id_menusite',$item->id_menusite,["class"=>"form-control"]) !!}
			@csrf()
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Femer</button>
					<button id="valider" type="button"  class="btn btn-primary btn-load" onclick="addAction();"> 
						<span class="d-flex align-items-center"><span class="flex-grow-1 me-2">Retourner</span><span class="flex-shrink-0" role="status"></span></span>
					</button>
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

		$.ajax({
			type: 'POST',url: '{{ url("/menusite/actionUpdate/")}}',data: $('#formAction').serialize(),
			success: function(data) {
				$('#valider').attr("disabled",!1);
				$('#valider .flex-shrink-0').removeClass("spinner-border");
				if(data.response!=1){
					$.each(data.response, function(Key, value){var ErrorID = '#'+Key+'Error';$(ErrorID).removeClass('d-none');$(ErrorID).text(value);})
				}else{
					$("div.msgAction").html('<div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert"><i class="ri-notification-off-line me-3 align-middle"></i> <strong>Infos </strong> Enregistrement r&eacute;ussi. </div>').show(200);
					window.location.reload();
				}
			},
			error: function(data) {}
		});
	}

</script>
