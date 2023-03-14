<div class="modal-content">
	<div class="modal-body text-center p-4">
		<div class="mt-2">
			<h4 class="mb-3 red-g" > {{trans('data.titre_delete')}} <i class="bx bxs-trash"></i></h4>
			<p class="text-muted mb-4"> Voulez-vous vraiment supprimer {{$item->nom_doc}} ? </p>
			<form  action="{{route('docu.destroy',$item->id_doc)}}" method="POST">
					@method('DELETE')
					@csrf()
				<button type="button" class="btn btn-light" data-bs-dismiss="modal">Non</button>
				<button id="submit" class="btn btn-danger">Oui</button>
			</form>
			<div class="hstack gap-2 justify-content-center"></div>
		</div>
	</div>
</div>
