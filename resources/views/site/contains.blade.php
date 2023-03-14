@extends('site.welcome')

@section('content')

    @if($activite)
      <!-- background-image: url('/assets/docs/logos/slide-3.jpg'); -->
        @if(!$activite->img_act)
          <section id="giwuhero">
            <div id="heroCarousel" style="height: 100vh;" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

              <div class="carousel-inner" role="listbox">

                <div class="carousel-item active" style="background-size: auto auto; background-image: url('/assets/docs/logos/slide-1.jpg');">
                </div>

                <div class="carousel-item" style="background-size: auto auto; background-image: url('/assets/docs/logos/slide-2.jpg');">
                </div>

                <div class="carousel-item active" style="background-size: auto auto; background-image: url('/assets/docs/logos/slide-3.jpg');">
                </div>

              </div>

            </div>
          </section><!-- End Hero -->
        @else
          <br><br><br><br><br><br>
        @endif
      @else
        <br><br><br><br><br><br>
    @endif
        <br>
      <div class="section-title">
          <h2>{{$infoMenu->libelle_menu}}</h2>
        </div>
    @if($activite)    
      <!--End Page Title-->

      
      <div class="m-4">
            @if($activite->img_act)
              <img src='{{"assets/docs/".$activite->img_act}}' class="card-img-top"  alt="...">
            @endif
            <div class="card-body m-4" >
            <h2 class="text-center">{{$activite->titre_act}}</h2>
              <!-- <div class="section-title"> -->
                  <!--  -->
                  <!-- @if($infoMenu->id_menusite != 2) 
                    <h2>{{$activite->titre_act}}</h2>
                    <p>{{$infoMenu->libelle_menu}}</p>
                  @endif -->
              <!-- </div> -->
              {!! $activite->descr_act !!}
            </div>
          <br>
      </div>
    @else
      <div Class="alert alert-info m-4 text-center"><strong>Info ! </strong>{!!trans('data.AucunInfosTrouvesite')!!} << {{$infoMenu->libelle_menu}} >> </div>
    @endif
@endsection
