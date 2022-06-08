<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Navbar brand -->

        <!-- Toggle button -->
        <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample"
                aria-controls="navbarButtonsExample"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-info" href="{{route('home')}}">Home</a>
                </li>

                @if(\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item">
                        <a class="nav-link text-info" href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                @endif
            </ul>
            <!-- Right links -->
            @if(\Illuminate\Support\Facades\Auth::check())
                <!-- drop down links -->
                @include('partials.auth.profile-button')
            @else

            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary text-info me-3">
                    <a class="text-white text-decoration-none" href="{{route('login')}}">Login</a>
                </button>
                <button type="button" class="btn btn-primary text-info me-3">
                    <a class="text-white text-decoration-none" href="{{route('register')}}">Register</a>
                </button>
            </div>
            @endif
        </div>
    </div>
</nav>