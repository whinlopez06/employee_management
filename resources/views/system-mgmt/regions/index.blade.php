@extends('system-mgmt.regions.base')

@section('action-content')
    <!--main content-->
    <section class="content">

        <div class="box">
            
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">List of regions</h3>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" id="addNewRegionModal" class="btn btn-primary" data-toggle="modal" data-target="#addRegionModal">
                            <span class="glyphicon glyphicon-plus"></span> Add New
                        </button>

                        <!-- <a class="btn btn-primary" href="{{ route('region.create') }}"><span class="glyphicon glyphicon-plus"> </span> Add new</a>-->
                    </div>
                </div>
            </div>
            <!-- /.box-header -->

            <div class="box-body">

                <div class="col-md-12">
                    @include('includes.rowcol')

                    <!--once you have assigned a name to a given route, you may use the route's name when generating URLs or redirects via the global route function:-->    
                    <form method="POST" action="{{ route('region.search') }}">
                        {{ csrf_field() }}
                        @component('layouts.search', ['title' => 'Search fields'])

                            @component('layouts.two-cols-search-row', [
                                'items' => ['search_name'],
                                'oldVals' => [isset($searchingVals) ? $searchingVals['search_name'] : '']
                                ])
                            @endcomponent


                        @endcomponent
                    </form>

                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div col-sm-12>
                                <table id="regionTable" class="table table-bordered table-hover dataTable" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th width="40%" tabindex="0" rowspan="1" colspan="1">Region Name</th>
                                            <th  tabindex="0" rowspan="1" colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($regions as $region)   
                                        <tr role="row" class="odd">
                                            <td>{{ $region->name }}</td>
                                            <td>
                                                <button class="btn btn-info" data-region_id="{{ $region->id }}" data-region_name="{{ $region->name }}"
                                                    data-toggle="modal" data-target="" data-backdrop="static"><span class='glyphicon glyphicon-edit'> </span> Edit</button>&nbsp;
                                                <button class="btn btn-danger" data-region_id="{{ $region->id }}" data-toggle="modal" data-target=""> <span class='glyphicon glyphicon-trash'> </span> Delete</button>    
                                            </td>
                                        </tr>     
                                    @endforeach
                                    </tbody>
                                </table>
        
                            </div>
                        </div>
                    </div>
                    <!--/.dataTables_wrapper-->

                    <div id="div-alert" class="alert text-center hidden" role="alert">
                        <span></span>  
                    </div>

                    <div class="dataTables_paginate paging_simple_numbers">
                        
                    </div>
                </div>                    
          
            
            </div>  
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

        @component('includes.horizontal-add-modal', ['title' => 'Region', 'formgroup' =>  'system-mgmt.regions.form'])
        @endcomponent

        @component('includes.horizontal-edit-modal', ['title' => 'Region', 'formgroup' =>  'system-mgmt.regions.form'])
            <input type="hidden" name="region_id" id="region_id">    
        @endcomponent

    </section>

    @include('users-mgmt.script')



@endsection