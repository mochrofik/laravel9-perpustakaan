
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Library </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="/home">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->

        @if (auth()->user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link collapsed" href="/books">
                <i class="fas fa-fw fa-book"></i>
                <span>Books</span>
            </a>
          
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/member-loans" 
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="bi bi-book-half"></i>
                <span>Loans</span>
            </a>
           
        </li>

       
            
        <li class="nav-item">
            <a class="nav-link collapsed" href="/member" 
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-user"></i>
                <span>Member</span>
            </a>
           
        </li>
        @else
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="/my-loans" 
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="bi bi-book-half"></i>
                <span>My Loans</span>
            </a>
           
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/loans" 
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-book"></i>
                <span>Books</span>
            </a>
           
        </li>



        @endif

        <!-- Divider -->
        

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

       

    </ul>
    <!-- End of Sidebar -->