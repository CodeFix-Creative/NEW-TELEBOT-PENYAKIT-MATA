<header id="header">
    <div class="container d-flex">

        <div class="logo mr-auto">
            <h1 class="text-light"><a href="index.html">Marvella</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('tentang-kami') }}">Tentang Kami</a></li>
                <li><a href="services.html">Layanan</a></li>
                @guest
                <li><a class="btn btn-sm px-3 text-white" style="background-color: #fd5c28;" href="{{ route('login') }}">Login</a></li>
                @endguest

                @auth
                <li><a href=""><i class="icofont-user mr-2"></i> {{ Auth::user()->nama }}</a></li>
                @endauth
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header>
