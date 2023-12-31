<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('vendor/dist/img/cas_128x128.png') }}" alt="Carpool Management Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Carpool Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (isset(auth()->user()->image_path))
                    @if (auth()->user()->image_path == null)
                        <img src="{{ asset('vendor/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            style="height: 38px; width: 38px; object-fit: cover; border-radius: 50%;" alt="User Image">
                    @else
                        <img src="{{ asset(auth()->user()->image_path) }}" class="img-circle elevation-2"
                            style="height: 38px; width: 38px; object-fit: cover; border-radius: 50%;" alt="User Image">
                    @endif
                @endif
            </div>
            <div class="info">
                @if (isset(auth()->user()->name))
                    <a href="{{ route('my-profile') }}" class="d-block">{{ auth()->user()->name }} </a>
                @endif
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (isset(auth()->user()->role))
                    @if (auth()->user()->role == 'Admin')
                        <li class="nav-item {{ request()->is('users/*') ? 'menu-open active' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('users/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User Management
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('all-users') }}"
                                        class="nav-link {{ request()->is('users/all-users') ? 'active' : '' }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>All Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('add-users') }}"
                                        class="nav-link {{ request()->is('users/add-users') ? 'active' : '' }}">
                                        <i class="fas fa-user-plus nav-icon"></i>
                                        <p>Add New User</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user-reviews') }}"
                                        class="nav-link {{ request()->is('users/user-reviews') ? 'active' : '' }}">
                                        <i class="fas fa-comments nav-icon"></i>
                                        <p>User Reviews</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user-ratings') }}"
                                        class="nav-link {{ request()->is('users/user-ratings') ? 'active' : '' }}">
                                        <i class="fas fa-star nav-icon"></i>
                                        <p>User Ratings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('users_awaiting_verification') }}"
                                        class="nav-link {{ request()->is('users/awaiting_verification') ? 'active' : '' }}">
                                        <i class="fas fa-user-check nav-icon"></i>
                                        <p>User Verification</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                <li class="nav-item {{ request()->is('announcements*') ? 'menu-open active' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('announcements*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            Announcements
                            <i class="fas fa-angle-left right"></i>
                            {{-- <span class="badge badge-info right">6</span> --}}
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (isset(auth()->user()->role))
                            @if (auth()->user()->role == 'Admin')
                                <li class="nav-item">
                                    <a href="{{ route('announcements.create') }}"
                                        class="nav-link {{ request()->is('announcements/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Announcements</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('announcements.index') }}"
                                class="nav-link {{ request()->is('announcements') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Announcements</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('my-profile') }}"
                        class="nav-link {{ request()->is('my-profile') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            My Profile
                        </p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('wallet*') ? 'menu-open active' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('wallet*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Wallet
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('wallet.show') }}"
                                class="nav-link {{ request()->is('wallet') ? 'active' : '' }}">
                                <i class="far fa-money-bill-alt nav-icon"></i>
                                <p>My Wallets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stripe.top-up') }}"
                                class="nav-link {{ request()->is('wallet/top-up') ? 'active' : '' }}">
                                <i class="fas fa-arrow-up nav-icon"></i>
                                <p>Top Up</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stripe.withdraw') }}"
                                class="nav-link {{ request()->is('wallet/withdraw') ? 'active' : '' }}">
                                <i class="fas fa-arrow-down nav-icon"></i>
                                <p>Withdraw</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('wallet.transfer') }}"
                                class="nav-link {{ request()->is('wallet/transfer') ? 'active' : '' }}">
                                <i class="fas fa-exchange-alt nav-icon"></i>
                                <p>Transfer</p>
                            </a>
                        </li>
                        @if (isset(auth()->user()->role))
                            @if (auth()->user()->role == 'Admin')
                                <li class="nav-item">
                                    <a href="{{ route('wallet.withdrawalRequest') }}"
                                        class="nav-link {{ request()->is('wallet/withdrawalRequest') ? 'active' : '' }}">
                                        <i class="fas fa-money-check-alt nav-icon"></i>
                                        <!-- Use appropriate Font Awesome class for "cash out" icon -->
                                        <p>Withdrawal Request</p>
                                    </a>
                                </li>
                            @endif
                        @endif

                    </ul>
                </li>

                {{-- <li class="nav-item {{ request()->is('trips*') ? 'menu-open active' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('trip*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-route"></i>
                        <p>
                            Trip Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('trips.myTrips') }}"
                                class="nav-link {{ request()->is('trips/myTrips') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Trips</p>
                            </a>
                        </li>
                        @php
                            $segments = explode('/', request()->path());
                            $isNumeric = count($segments) > 1 && is_numeric($segments[1]);
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('trips.index') }}"
                                class="nav-link {{ request()->is('trips') || (request()->is('trips*') && $isNumeric) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Trips</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('trips.create') }}"
                                class="nav-link {{ request()->is('trips/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Trips</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('trips.search') }}"
                                class="nav-link {{ request()->is('trips/search*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search Trip</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('contacts') }}"
                        class="nav-link {{ request()->is('contacts*') || request()->is('user-profile*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            Contacts
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('chat.chat', 0) }}"
                        class="nav-link {{ request()->is('chat*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-comment"></i>
                        <p>
                            Chat
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('auth/settings*') ? 'menu-open active' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('auth/settings/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                            {{-- <span class="badge badge-info right">6</span> --}}
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('auth.settings.account') }}"
                                class="nav-link {{ request()->is('*account') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('auth.settings.reset-password') }}"
                                class="nav-link {{ request()->is('auth/settings/reset-password') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                {{-- <li class="nav-item">
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div> --}}
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
