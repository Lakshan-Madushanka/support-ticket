<header class="header" id="header">
    <div class="header_toggle"><i class="bx bx-menu" id="header-toggle"></i></div>
    <div class="">
        @include('partials.auth.profile-button')
    </div>
</header>

<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo"> <i class="bx bx-layer nav_logo-icon"></i> <span
                        class="nav_logo-name">LakM</span> </a>
            <div class="nav_list">
                <a href="{{route('home')}}" class="nav_link
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() === 'home')
                             active
                        @endif
                        ">
                    <i class="bx bx-grid-alt nav_icon"></i><span class="nav_name">Home</span>
                </a>
                <a href="{{route('support-ticket.index')}}" class="nav_link
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() === 'support-ticket.index')
                         active
                        @endif
                        ">
                    <i class="bx bx-message-square-detail nav_icon"></i> <span class="nav_name">Tickets</span>
                </a>
                <a href="{{route('support-ticket-replies.index')}}" class="nav_link
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() === 'support-ticket-replies.index')
                          active
                        @endif
                        ">
                    <i class="bx bx-bookmark nav_icon"></i> <span class="nav_name">Replies</span>
                </a>
            </div>
        </div>
        <form method="post" action="{{route('logout')}}">
            @csrf
            <button type="submit" class="nav_link">
                <i class="bx bx-log-out nav_icon"></i>
                <span class="nav_name">SignOut</span>
            </button>
        </form>
    </nav>
</div>

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId);

                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener("click", () => {
                        // show navbar
                        nav.classList.toggle("show");
                        // change icon
                        toggle.classList.toggle("bx-x");
                        // add padding to body
                        bodypd.classList.toggle("body-pd");
                        // add padding to header
                        headerpd.classList.toggle("body-pd");
                    });
                }
            };

            showNavbar("header-toggle", "nav-bar", "body-pd", "header");

            /*===== LINK ACTIVE =====*/
            const linkColor = document.querySelectorAll(".nav_link");

            function colorLink() {
                if (linkColor) {
                    linkColor.forEach((l) => l.classList.remove("active"));
                    this.classList.add("active");
                }
            }

            linkColor.forEach((l) => l.addEventListener("click", colorLink));

            // Your code to run since DOM is loaded and ready
        });
    </script>
@endpush
