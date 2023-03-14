@extends('site.welcome')

@section('content')
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>




    <div class="section-title">
        <h2>{{$infoMenu->libelle_menu}}</h2>
      </div>
    <!--End Page Title-->
    @if(count($listactivite) != 0)
    <div class="row m-4">
      @foreach ($listactivite as $act)
        <div class="col-4">

          <div class="card mb-3">
            <img class="card-img-top" src='{{"assets/docs/".$act->img_act}}' alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">{{$act->titre_act}}</h5>
              <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
            </div>
            <div class="card-footer text-center">
              <small class="text-muted">
                @if($act->menusite_id == 6 )  
                  <a href="{{\App\Models\Menusite::returnLinkActivit($act->id_activite)}}" class="btn btn-sm btn-outline-secondary">En savoir plus</a>
                @else
                  <a href="{{\App\Models\Menusite::returnLink($act->menusite_id)}}" class="btn btn-sm btn-outline-secondary">En savoir plus</a>
                @endif
                </small>
            </div>
          </div>
        </div>
      @endforeach
      
    </div>
    <!-- Pagination -->
    <div class="m-4">
      {!! $listactivite->links() !!}
    </div>
    @else
      <div Class="alert alert-info m-4 text-center"><strong>Info ! </strong>{!!trans('data.AucunInfosTrouvesite')!!} << {{$infoMenu->libelle_menu}} >> </div>
    @endif
@endsection
