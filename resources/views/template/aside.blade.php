<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info elevation-4 text-sm">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-sm">
        <img src="{{ asset('images/apps/app.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">WINA V1.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- origin -->
            <div class="image">
                <img src="{{ asset(session('user')->user_image)}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ session('user')->full_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- USER MATRIX -->
                {{ createMenu($page,$parent_page) }}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>