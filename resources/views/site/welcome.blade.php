<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

 
    <!-- Favicons -->
    <link href='{{ asset("assets/site/assets/img/favicon.png") }}' rel="icon">
    <link href='{{ asset("assets/site/assets/img/apple-touch-icon.png") }}' rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('assets/css/mystyle.css') }}" rel="stylesheet" type="text/css" />
    <!-- Vendor CSS Files -->
    <link href='{{ asset("assets/site/assets/vendor/fontawesome-free/css/all.min.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/animate.css/animate.min.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/aos/aos.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/bootstrap/css/bootstrap.min.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/bootstrap-icons/bootstrap-icons.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/boxicons/css/boxicons.min.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/glightbox/css/glightbox.min.css") }}' rel="stylesheet">
    <link href='{{ asset("assets/site/assets/vendor/swiper/swiper-bundle.min.css") }}' rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href='{{ asset("assets/site/assets/css/style.css") }}' rel="stylesheet">

    @yield("css")
</head>

<body >
  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
      <div class="align-items-center d-none d-md-flex">
        <i class="bi bi-clock"></i> {{$societe->pied_page_soc}}
      </div>
      <div class="d-flex align-items-center">
        <i class="bi bi-phone"></i>{{$societe->mail_soc}}
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <a href="{{url('/')}}" class="logo me-auto">
        <img src="{{url('assets/docs/logos/'.$societe->logo_soc)}}" alt="">
    </a>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <h1 class="logo me-auto"><a href="/">Medicio</a></h1> -->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link" href="/">{{ __('Accueil') }}</a></li>
            @foreach($menusit as $menu)
              <?php $listSousMenu = App\Models\Menusite::SousMenu($menu->id_menusite);?>
              <!-- Menu principale -->
              @if(sizeof($listSousMenu) == 0)
                <li><a href="{{ $menu->type_affiche}}{{trans('data.val_giwu')}}{{ $menu->code }}">{{ $menu->libelle_menu }}</a></li>
              @else 
                <li class="dropdown">
                  <a href="#"><span>{{ $menu->libelle_menu }}</span> <i class="bi bi-chevron-down"></i></a>
                  <ul>
                    @foreach($listSousMenu as $listsm)
                      <li><a href="{{$listsm->type_affiche}}{{trans('data.val_giwu')}}{{ $listsm->code }}">{{ $listsm->libelle_menu }}</a></li>
                    @endforeach
                  </ul>
                </li>
              @endif
            @endforeach
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  @yield("content")

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>DNPM</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medicio-free-bootstrap-theme/ -->
        Designed by <a href="https://eviltech.org">Filatech Technologies</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  {{-- <div id="preloader"></div> --}}
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src='{{ asset("assets/site/assets/vendor/purecounter/purecounter.js") }}'></script>
    <script src='{{ asset("assets/site/assets/vendor/aos/aos.js") }}'></script>
    <script src='{{ asset("assets/site/assets/vendor/bootstrap/js/bootstrap.bundle.min.js") }}'></script>
    <script src='{{ asset("assets/site/assets/vendor/glightbox/js/glightbox.min.js") }}'></script>
    <script src='{{ asset("assets/site/assets/vendor/swiper/swiper-bundle.min.js") }}'></script>
    <script src='{{ asset("assets/site/assets/vendor/php-email-form/validate.js") }}'></script>

    <!-- Template Main JS File -->
    <script src='{{ asset("assets/site/assets/js/main.js") }}'></script>

</body>

</html>
