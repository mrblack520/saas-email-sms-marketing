<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->

<div class="app-container">
<div class="fadetoblack visible-xs"></div>
<div class="row content-container">







<!--**********************************
Main wrapper start
***********************************-->
<div id="main-wrapper">

<!--**********************************
    Nav header start
***********************************-->
<div class="nav-header">
    <a href="/dashboard" class="brand-logo">
        <div class="logo-abbr">

            <img class="logo-abbr" src="{{ asset('Buy_Later/buy later/logoadmin.png') }}" alt="">
        </div>

        <div class="brand-title">
            <img class="logo-title"  src="{{ asset('Buy_Later/buy later/text.png') }}" alt="">

        </div>



    </a>


</div>
<!--**********************************
    Nav header end
***********************************-->


<!--**********************************
Header start
***********************************-->
<div class="header">
<div class="header-content">
<nav class="navbar navbar-expand">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="header-left">
            <div class="dashboard_bar">
                Dashboard
            </div>
        </div>
        <ul class="navbar-nav header-right">


            <li class="nav-item dropdown header-profile">
                <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                    <img src="{{ Voyager::image(auth()->user()->avatar) . '?' . time() }}" width="20" alt=""/>
                    <div class="header-info">
                        <span class="text-black">{{ auth()->user()->name }}</span>
                        <p class="fs-12 mb-0">{{ auth()->user()->username }}</p>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('wave.profile', auth()->user()->username) }}" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="ms-2">Profile </span>
                    </a>

                    <a href="{{ route('wave.logout') }}" class="dropdown-item ai-icon">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="ms-2">Logout </span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
</div>
</div>        <!--**********************************
    Header end ti-comment-alt
***********************************-->

<!--**********************************
    Sidebar start
***********************************-->
<div class="dlabnav">
<div class="dlabnav-scroll">
    <ul class="metismenu" id="adminmenu">
        <admin-menu :items="{{ menu('admin', '_json') }}"></admin-menu>
        
    </ul>
</div>
</div>   

<!--**********************************
    Sidebar end
***********************************-->









        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
</div>
</div>
