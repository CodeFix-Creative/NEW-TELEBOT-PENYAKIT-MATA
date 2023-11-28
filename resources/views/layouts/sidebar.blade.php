<ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="@yield('dashboard')"><a class="nav-link" href="#!"><i class="fas fa-fire"></i> <span>Dashboard</span></a>

    <li class="menu-header">Aksesbilitas</li>
    <li class="@yield('user')"><a class="nav-link" href="{{ route('user.index') }}"><i class="fa-solid fa-users"></i> <span>User</span></a>
    </li>

    <li class="menu-header">Administration</li>
    <li class="@yield('gejala')"><a class="nav-link" href="{{ route('gejala.index') }}"><i class="fa-solid fa-stethoscope"></i> <span>Gejala</span></a>
    </li>
    <li class="@yield('penyakit')"><a class="nav-link" href="{{ route('penyakit.index') }}"><i class="fa-solid fa-heart-pulse"></i>
            <span>Penyakit</span></a>
    </li>
    <li class="@yield('penyakit-gejala')"><a class="nav-link" href="{{ route('penyakit-gejala.index') }}"><i class="fa-solid fa-hospital-user"></i> <span>Penyakit Gejala</span></a>
    </li>
    <li class="@yield('manual')"><a class="nav-link" href="{{ route('diagnosa.index') }}"><i class="fa-solid fa-briefcase-medical"></i> <span>Manual Diagnosis</span></a>
    </li>
    <li class="@yield('record')"><a class="nav-link" href="{{ route('record.index') }}"><i class="fa-solid fa-hospital-user"></i> <span>Record Diagnosa</span></a>
    </li>
</ul>
