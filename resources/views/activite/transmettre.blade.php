<div class="modal-content">
	<div class="modal-body text-center p-4">
		<div class="mt-2">
			@if($type == 'trans') <!-- Code Transmettre -->
				<h4 class="mb-3" > {{trans('data.titre_transmettre')}}</h4>
				<p class='text-muted mb-4'> Voulez-vous vraiment transmettre {{$item->titre_act}} pour validation ? </p>
				<form  action="{{ url('/activite/affect'.$type.'/'.$item->id_activite)}}" method='POST'>
					@csrf()
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Non</button>
					<button id="submit" class="btn btn-warning">Oui</button>
				</form>
			@elseif($type == 'go') <!-- Code Validation -->
				<h4 class="mb-3" > {{trans('data.titre_publier')}}</h4>
				<p class='text-muted mb-4'> Voulez-vous vraiment publier {{$item->titre_act}} ? </p>
				<form  action="{{ url('/activite/affect'.$type.'/'.$item->id_activite)}}" method='POST'>
					@csrf()
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Non</button>
					<button id="submit" class="btn btn-secondary">Oui</button>
				</form>
			@elseif($type == 'stop') <!-- Code Arreter de publier -->
				<h4 class="mb-3" > {{trans('data.titre_Arreterdepublier')}}</h4>
				<p class='text-muted mb-4'> Voulez-vous vraiment arr&ecirc;ter de publier {{$item->titre_act}} ? </p>
				<form  action="{{ url('/activite/affect'.$type.'/'.$item->id_activite)}}" method='POST'>
					@csrf()
					<button type="button" class="btn btn-light" data-bs-dismiss="modal">Non</button>
					<button id="submit" class="btn btn-danger">Oui</button>
				</form>
			@endif
			<div class="hstack gap-2 justify-content-center"></div>
		</div>
	</div>
</div>
