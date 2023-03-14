@extends('site.welcome')

@section('content')


    <section id="giwuhero">
        <div id="heroCarousel" style="height: 100vh;" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item " style="background-size: auto auto; background-image: url('/assets/docs/logos/slide-1.jpg');">
                </div>
                <div class="carousel-item " style="background-size: auto auto; background-image: url('/assets/docs/logos/slide-2.jpg');">
                </div>
                <div class="carousel-item active" style="background-size: auto auto; background-image: url('/assets/docs/logos/slide-3.jpg');">
                </div>
            </div>
        </div>
    </section><!-- End Hero -->
    <br>
    <div class="section-title">
        <h2>{{$infoMenu->libelle_menu}}</h2>
      </div>
    <!--End Page Title-->

    @if(count($listDocument) != 0)
        <div class="row">
            <section id="about" class="about">
                <div class="container">
                <div class="row">
                    <div class="col-lg-12 pt-4 pt-lg-0 content">
                        <table class="table table-bordered mb-5">
                            <thead>
                                <tr style="background-color: #d5e5d0;">
                                    <th scope="col"  class="text-center">#</th>
                                    <th scope="col">{!!trans('data.nom_doc')!!}</th>
                                    <th scope="col">{!!trans('data.autre_inf')!!}</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php $i=0;?>
                                @foreach ($listDocument as $listDoc)

                                    <?php $i++;?>
                                    <tr>
                                        <td scope="row"  class="text-center">{{$i}}</td>
                                        <td scope="row">{{ $listDoc->nom_doc }}</td>
                                        <td>{{ $listDoc->autre_inf }}</td>
                                        <td class="text-center">
                                            @if($listDoc->Fichier && $listDoc->telecharger_doc == 'Oui')
                                                <a href='{{"assets/docs/".$listDoc->Fichier}}' target="_blank" class="badge bg-danger">Télécharger</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="m-4">
                            {!! $listDocument->links() !!}
                        </div>
                    </div>
                </div>

                </div>
            </section>
        </div>
    @else
      <div Class="alert alert-info m-4 text-center"><strong>Info ! </strong>{!!trans('data.AucunInfosTrouvesite')!!} << {{$infoMenu->libelle_menu}} >> </div>
    @endif
@endsection
