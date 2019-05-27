<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('images/avatar5.png')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <!--check if they are signed in yet before trying to access user properties.-->
                <div class="pull-left info">
                    @if(auth::check())
                        <p>{{ auth::user()->username }}</p>
                    @endif

                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- <li class="header">HEADER</li> -->
            <li class="active"><a href="/"><i class="fa fa-link"></i><span>Dashboard</span></a></li>
            
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('category') }}"><i class="fa fa-link"></i> <span>Category</span></a></li>
            
            <li ><a href="{{ url('projects')}}"><i class="fa fa-link"></i><span>Projects</span></a></li>

            <!--*<li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                <li><a href="#">Link in level 2</a></li>
                <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>*-->

            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>System Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!--GET/HEAD|system-management/region|region.index|App\Http\Controllers\RegionsController@index-->
                    <li><a href="{{ url('system-management/region') }}">Region</a></li>

                </ul>
            </li>
            <!-- <li><a href="{{ route('region.index') }}"><i class="fa fa-link"></i><Span>Region</Span></a></li> -->
            
            <!-- route using the name route in your web.php -->
            <li><a href="{{ route('user-management.index') }}"><i class="fa fa-link"></i><Span>User Management</Span></a></li>
        </ul>
        <!-- /.sidebar-menu -->

    </section>
    <!-- /.sidebar -->

</aside>