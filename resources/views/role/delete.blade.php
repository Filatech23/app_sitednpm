
<div class="modal-content">
    <div class="modal-body text-center p-4">
        <div class="mt-2">
            <h4 class="mb-3 red-g" > <i class="bx bxs-trash"></i>  {{trans('data.libelle_role')}}</h4>
            <p class="text-muted mb-4"> Voulez-vous vraiment supprimer {{$item->libelle_role}} ? </p>
            <form  action="{{route('role.destroy',$item->id_role)}}" method="POST">
                    @method('DELETE')
                    @csrf()
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Non</button>
                <button id="submit" class="btn btn-danger">Oui</button>
            </form>
            <div class="hstack gap-2 justify-content-center">
            </div>
        </div>
    </div>

</div>

