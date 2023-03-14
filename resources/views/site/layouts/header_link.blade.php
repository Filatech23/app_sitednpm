
<!-- Header-start - Menu -->
    <?php 
        $menu = \App\Models\Menusite::where('etat_menu','p')->get()->toArray();
        $array = [];
        if(count($menu) != 0){
            foreach($menu as $sli){
                array_push($array,$sli['id_menu']);
            }
        }
        $societe = \App\Models\GiwuSociete::where('id_societe',1)->first();
    ?>
    <header id="header" class="header header-two">
        <div class="container">
            <div class="flex-header">
                <div class="logo"><a href="{{url('/')}}" title="{{$societe->nom_soc}}">M<span class="text-primary">229</span>pictures</a></div>
                <div class="content-menu">
                    <div class="nav-menu">
                        <div class="btn-menu"><span></span></div>
                        <nav id="main-menu" class="main-menu">
                            <ul class="menu">
                                @if(in_array('1',$array))
                                    <li><a href="{{url('/who')}}">{{\App\Models\Menusite::libelleMenu(1)['titre_menu']}}</a></li>
                                @endif
                                @if(in_array('2',$array))
                                    <li><a href="{{url('/serv')}}">{{\App\Models\Menusite::libelleMenu(2)['titre_menu']}}</a></li>
                                @endif
                                @if(in_array('3',$array))
                                    <li><a href="{{url('/real')}}">{{\App\Models\Menusite::libelleMenu(3)['titre_menu']}}</a></li>
                                @endif
                                @if(in_array('4',$array))
                                    <li><a href="{{url('/cont')}}">{{\App\Models\Menusite::libelleMenu(4)['titre_menu']}}</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header><!-- header -->
    <!-- Mobile-menu-header-start - Menu -->
    <header class="mobile-header">
        <div class="container">
            <div class="flex-header">
                <div class="logo"><a href="{{url('/')}}" title="{{$societe->nom_soc}}">M<span class="text-primary">229</span></a></div>
                <div class="content-menu">
                    <div class="nav-menu">
                        <div class="btn-menu"><span></span></div>
                        <nav class="mobile-menu">
                            <ul class="menu">
                                @if(in_array('1',$array))
                                    <li><a href="{{url('/who')}}">{{\App\Models\Menusite::libelleMenu(1)['titre_menu']}}</a></li>
                                @endif
                                @if(in_array('2',$array))
                                    <li><a href="{{url('/serv')}}">{{\App\Models\Menusite::libelleMenu(2)['titre_menu']}}</a></li>
                                @endif
                                @if(in_array('3',$array))
                                    <li><a href="{{url('/real')}}">{{\App\Models\Menusite::libelleMenu(3)['titre_menu']}}</a></li>
                                @endif
                                @if(in_array('4',$array))
                                    <li><a href="{{url('/cont')}}">{{\App\Models\Menusite::libelleMenu(4)['titre_menu']}}</a></li>
                                @endif
                            </ul>
                        </nav>

                    </div>

                </div>
            </div>
        </div>
    </header>
    <!-- end -->