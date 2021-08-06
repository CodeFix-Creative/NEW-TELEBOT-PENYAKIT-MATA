<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama ?? 'User' }}" alt="..."
                        class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span class="ellipsis">
                            {{ Auth::user()->nama ?? 'User' }}
                            <span class="user-level">{{ Auth::user()->role ?? 'Guest' }}</span>
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
                @if (auth()->user()->role == 'Super Admin' || auth()->user()->role == 'Admin')
                <li class="nav-item @yield('admin')">
                    <a href="{{ route('admin.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-users-cog"></i>
                        <p>Admin</p>
                    </a>
                </li>
                <li class="nav-item @yield('customer service')">
                    <a href="{{ route('customerservice.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-headset"></i>
                        <p>Customer Service</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('*sparepart*')) ? 'active' : '' }}">
                    <a href="{{ route('sparepart.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-cogs"></i>
                        <p>Spare Part</p>
                    </a>
                </li>
                <li class="nav-item @yield('service')">
                    <a href="{{ route('service.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-clipboard-check"></i>
                        <p>Service Status</p>
                    </a>
                </li>
                <li class="nav-item {{ (request()->is('*bookingtime*')) ? 'active' : '' }}">
                    <a href="{{ route('bookingtime.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Booking Time</p>
                    </a>
                </li>
                @endif

                <li class="nav-item {{ (request()->is('*bookingList*')) ? 'active' : '' }}">
                    <a href="{{ route('bookingList.index') }}" class="collapsed" aria-expanded="false">
                        <i class="fas fa-calendar-check"></i>
                        <p>Booking Request List</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
