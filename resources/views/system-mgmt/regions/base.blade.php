@extends('layouts.master')

@section('content')

    <div class="content=wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Region Management</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i>System Management</a></li>
                <li class="active">Region</li>
            </ol>
        </section>


        @yield('action-content')
    </div>
    <!--/.content=wrapper-->
@endsection