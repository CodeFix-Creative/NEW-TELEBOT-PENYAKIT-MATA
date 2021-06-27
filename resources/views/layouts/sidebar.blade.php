<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama ?? 'User' }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span class="ellipsis">
                            {{ Auth::user()->nama ?? 'User' }}
                            <span class="user-level">{{ Auth::user()->roles->role ?? 'Guest' }}</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ (request()->is('*dashboard*') || @$dashboard) ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('*user*')) ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('*jenis_desain*')) ? 'active' : '' }}">
                    <a href="#" class="collapsed" aria-expanded="false">
                        <i class="fas fa-list"></i>
                        <p>Menu 2</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('*desain*') && !request()->is('*jenis_desain*')) ? 'active' : '' }}">
                    <a href="#" class="collapsed" aria-expanded="false">
                        <i class="fas fa-palette"></i>
                        <p>Menu 3</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('*pesanan*')) ? 'active' : '' }}">
                    <a href="#" class="collapsed" aria-expanded="false">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Menu 4</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
