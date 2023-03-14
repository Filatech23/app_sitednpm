@extends('site.welcome')

@section('content')

  <!-- ======= Hero Section ======= -->

  @if($Countactiv != 0)

    @if(count($activit) != 0)
      <section id="hero">
          <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
            <div class="carousel-inner" role="listbox">
              <!-- une -->
              <?php $i=0;?>
              @foreach($activit as $acti)
              <?php $i++;?>
                <div class="carousel-item {{ $i == 1 ? "active":"" }}" style='background-image: url({{ "assets/docs/".$acti->img_act }}) '>
                    <div class="container">
                      <h2>{{$acti->titre_act}}</h2>
                      <a href="{{\App\Models\Menusite::returnLink($acti->menusite_id)}}" class="btn-get-started">Lire la suite</a>
                    </div>
                </div>
              @endforeach
            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
              <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
              <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
          </div>
      </section><!-- End Hero -->
    @else
        <br>
        <br>
        <br>
        <br>
        <br>
    @endif
  @else
      <br>
      <br>
      <br>
      <br>
      <br>
  @endif



  @if($apropos && $aproposmenu)
      <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">
            <div class="text-center">
                <h3>{{$aproposmenu->libelle_menu}}</h3>
                <p>{{$apropos->titre_act}}</p>
                <a class="cta-btn scrollto" href="{{\App\Models\Menusite::returnLink($apropos->menusite_id)}}">En savoir plus</a>
            </div>
        </div>
    </section><!-- End Cta Section -->
  @endif



  <!-- ======= About Us Section ======= -->

  @if($motdirect)  
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>{{$motdirect->titre_act}}</h2>
            <p></p>
          </div>
          <!-- style='background-image: url({{ "assets/docs/".$acti->img_act }}) ' -->
          <div class="row">
            @if($motdirect->img_act)
              <div class="col-lg-6" data-aos="fade-right">
                <img src="{{ asset('assets/docs/'.$motdirect->img_act) }}" class="img-fluid" alt="">
              </div>
            @endif
            <div class="col-lg-{{$motdirect->img_act ? 6 : 12}} pt-4 pt-lg-0 content" data-aos="fade-left">
              {!! $motdirect->descr_act !!}
            </div>
          </div>

        </div>
    </section><!-- End About Us Section -->
  @endif


  @if(count($statistique) != 0)
      <!-- ======= Counts Section ======= -->
      <section id="counts" class="counts">
        <div class="container" data-aos="fade-up">

          <div class="row no-gutters">
            @foreach($statistique as $stat)
              <div class="col-lg-{{12/count($statistique)}} col-md-6 d-md-flex align-items-md-stretch">
                <div class="count-box">
                  <i class="fas fa-hospital"></i>
                  <span data-purecounter-start="0" data-purecounter-end="{{$stat->titre_act}}" data-purecounter-duration="1" class="purecounter"></span>
                  <p>{!! $stat->descr_act !!} </p>
                </div>
              </div>
            @endforeach
          </div>

        </div>
      </section><!-- End Counts Section -->
  @endif


  @if(count($organisa) != 0 && $organisaFirst)
      <!-- ======= Departments Section ======= -->
      <section id="departments" class="departments">
        <div class="container" data-aos="fade-up">
          
          <div class="section-title">
            <h2>{{$organisaFirst->libelle_menu}}</h2>
            <!-- <p>Pour assurer sa mission, la Direction Nationale de la Pharmacie et du Médicament
                comprend deux divisions :</p> -->
          </div>

          <div class="row" data-aos="fade-up" data-aos-delay="100">

            <div class="col-lg-4 mb-5 mb-lg-0">
              <ul class="nav nav-tabs flex-column">
                <?php $i = 0;?>
                @foreach($organisa as $orga)
                  <?php $i++;?>
                  <li class="nav-item">
                    <a class="nav-link {{ $i == 1 ? 'active show': ''}}" data-bs-toggle="tab" data-bs-target="#tab-{{$orga->id_activite}}">
                      <h4>{{$orga->titre_act}}</h4>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>

            <div class="col-lg-8">
              <div class="tab-content">
                <?php $i = 0;?>
                @foreach($organisa as $orga)
                  <?php $i++;?>
                  <div class="tab-pane {{ $i == 1 ? 'active show': ''}}" id="tab-{{$orga->id_activite}}">
                    <h3>{{$orga->titre_act}}</h3>

                    {!! $orga->descr_act !!}
                  </div>
                @endforeach
              </div>
            </div>
          </div>

        </div>
      </section><!-- End Departments Section -->
  @endif


  @if(count($listPerson) != 0 && $listPersonFirst)
    <section id="doctors" class="doctors section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>{{$listPersonFirst->libelle_menu}}</h2>
          <p></p>
        </div>

        <div class="row">
        @foreach($listPerson as $listPe)
          <div class="col-lg-{{12/count($listPerson)}}  col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="100">
              <div class="member-img">
                <img src="{{ asset('assets/docs/'.$listPe->img_act) }}" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-twitter"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>{{$listPe->titre_act}}</h4>
                <span class="text-black">{!! $listPe->descr_act !!} </span>
              </div>
            </div>
          </div>
        @endforeach
        </div>
      </div>
    </section>
  @endif
    <!-- End Doctors Section -->

  <!-- ======= Gallery Section ======= -->
  @if(count($listPartena) != 0 && $listPartenaFirst)
    <section id="gallery" class="gallery">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>{{$listPartenaFirst->libelle_menu}}</h2>
        </div>

        <div class="gallery-slider swiper">
          <div class="swiper-wrapper align-items-center">
            @foreach($listPartena as $listP)
              <div class="swiper-slide"><a class="gallery-lightbox" href="{{ asset('assets/docs/'.$listP->img_act) }}"><img src="{{ asset('assets/docs/'.$listP->img_act) }}" class="img-fluid" alt=""></a></div>
            @endforeach
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Gallery Section -->
  @endif

  <!-- @include('site.contact') -->
  
<section id="contact" class="contact">
  <div class="container">

    <div class="section-title">
      <h2>Contact</h2>
    </div>
  </div>
  <div>
    <iframe style="border:0; width: 100%; height: 350px;" src="{{$societe->localisation}}" frameborder="0" allowfullscreen></iframe>
  </div>
  <div class="container">
    <div class="row mt-5">
      <div class="col-6">

        <div class="row">
          <div class="col-md-12">
            <div class="info-box">
              <i class="bx bx-map"></i>
              <h3>Adresse</h3>
              <p>{{$societe->adres_soc}}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mt-4">
              <i class="bx bx-envelope"></i>
              <h3>E-mail</h3>
              <p>{{$societe->mail_soc}}<br></p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mt-4">
              <i class="bx bx-phone-call"></i>
              <h3>Téléphone</h3>
              <p>{{$societe->contact_soc}}</p>
            </div>
          </div>
        </div>

      </div>
      <!--  -->
      <div class="col-6">
        <strong><div class="msgAction"></div></strong>
        
        <form method="post" role="form" id="formAction" class="php-email-form" enctype="multipart/form-data">
          @csrf()
          <div class="row">
            <!--  -->
            <div class="col-6">
              <input type="text" name="nom_prenom_cont" class="form-control" id="nom_prenom_cont" placeholder="Votre nom" required>
              <span class="text-danger" id="nom_prenom_contError"></span>
            </div>
            <!--  -->
            <div class="col-6">
              <input type="email" class="form-control" name="mail_cont" id="mail_cont" placeholder="Votre e-mail" required>
              <span class="text-danger" id="mail_contError"></span>
            </div>
            <!--  -->
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="sujet_cont" id="sujet_cont" placeholder="Sujet" required>
            <span class="text-danger" id="sujet_contError"></span>
          </div>
          <!--  -->
          <div class="form-group mt-3">
            <textarea class="form-control" name="msg_cont" rows="5" placeholder="Message" id="msg_cont" required></textarea>
            <span class="text-danger" id="msg_contError"></span>
          </div>
          <!--  -->
          <div class="text-center mt-3">
              <input type="button" class="btn-get-started" value="Envoyez" onclick="Sendpost();" id="valider">
          </div>
        </form>
      </div>

    </div>

  </div>
</section><!-- End Contact Section -->


   <script src="{{url('assets/js/jquery.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
        function Sendpost(){
          $('#valider').attr("disabled",!0);
          
        $('#valider .flex-shrink-0').addClass("spinner-border");
        $("div.msgAction").html('').hide(200);
        $('#nom_prenom_contError').addClass('d-none');
        $('#mail_contError').addClass('d-none');
        $('#sujet_contError').addClass('d-none');
        $('#msg_contError').addClass('d-none');
        var form = $('#formAction')[0];
        var data = new FormData(form);
        $.ajax({
            type: 'POST',url: '{{ url("/contact/")}}',
            enctype:'multipart/form-data',data: data,processData: false,contentType: false,
            success: function(data) {
            $('#valider').attr("disabled",!1);
            $('#valider .flex-shrink-0').removeClass("spinner-border");
            if(data.response==1){
                $("div.msgAction").html('<div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert"><i class="ri-notification-off-line me-3 align-middle"></i> <strong>Infos : </strong> Votre demande a été bien transmise</div>').show(200);
                $('#nom_prenom_contError').addClass('d-none');
                $('#mail_contError').addClass('d-none');
                $('#sujet_contError').addClass('d-none');
                $('#msg_contError').addClass('d-none');
                
                $('#nom_prenom_cont').val('');
                $('#mail_cont').val('');
                $('#msg_cont').val('');
                $('#sujet_cont').val('');
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

@endsection