@extends('users-mgmt.base')

@section('action-content')
    <!--main content-->
    <section class="content">

        <div class="box">
            
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="box-title">List of users</h3>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" id="addNewUser" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal" data-backdrop="static">
                                <span class="glyphicon glyphicon-plus"></span> Add New
                        </button>
                        <!-- <a class="btn btn-primary" href="{{ route('user-management.create') }}"><span class="glyphicon glyphicon-plus"> </span> Add new</a>-->
                    </div>
                </div>
            </div>
            <!-- /.box-header -->

            
            <div class="box-body">

                <div class="col-md-12">
                    @include('includes.rowcol')

                    <!--once you have assigned a name to a given route, you may use the route's name when generating URLs or redirects via the global route function:-->    
                    <form method="POST" action="{{ route('user-management.search') }}">
                        {{ csrf_field() }}
                        @component('layouts.search', ['title' => 'Search fields'])

                            @component('layouts.two-cols-search-row', [
                                'items' => ['search_username', 'search_email'],
                                'oldVals' => [isset($searchingVals) ? $searchingVals['search_username'] : '',
                                    isset($searchingVals) ? $searchingVals['search_email'] : '']])
                            @endcomponent

                            <br/>
                            
                            @component('layouts.two-cols-search-row', [
                                'items' => ['search_firstname', 'search_lastname'],
                                'oldVals' => [isset($searchingVals) ? $searchingVals['search_firstname'] : '',
                                    isset($searchingVals) ? $searchingVals['search_lastname'] : '']])
                            @endcomponent


                        @endcomponent
                    </form>

                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div col-sm-12>
        
                                <table id="userTable" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr role="row">
                                            <th width="15%">Username</th>
                                            <th width="20%">Email</th>
                                            <th width="15%">Firstname</th>
                                            <th width="15%">Lastname</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    @foreach($users as $user)
                                        <tr role="row" class="user-{{ $user->id }}">
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->firstname }}</td>
                                            <td>{{ $user->lastname }}</td>
                                            <td>    
                                            <button class="btn btn-info" data-user_id="{{ $user->id }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" 
                                                    data-firstname="{{ $user->firstname }}" data-middlename="{{ $user->middlename }}" data-lastname="{{ $user->lastname }}" 
                                                    data-toggle="modal" data-target="#editUserModal" data-backdrop="static"><span class='glyphicon glyphicon-edit'> </span> Edit</button>&nbsp;
                                                <button class="btn btn-danger" data-user_id="{{ $user->id }}" data-toggle="modal" data-target="#deleteUserModal">
                                                <span class='glyphicon glyphicon-trash'> </span> Delete</button>
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
                        {!! $users->links() !!}
                    </div>
                </div>                    
          
            
            </div>  
            <!-- /.box-body -->

        </div>
        <!-- /.box -->


    <!-- Modal starts here -->  
    <!-- Add Modal -->  
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addUserModalLabel">Add New User</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        @include('users-mgmt.form')  
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="createUser">
                        <span class="glyphicon glyphicon-plus"></span> Create
                    </button>
                    <button class="btn btn-warning" data=mytitle data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Close</button>
                </div>

            </div>    
        </div>
    </div>

    <!--Edit Modal-->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editUserModalLabel">Update User</h4>
                </div>
        
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        @include('users-mgmt.form')  
                        <input type="hidden" name="user_id" id="user_id">
                    </form>
                </div>
        
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="updateUser">
                        <span class="glyphicon glyphicon-check"></span> Update
                    </button>
                    <button class="btn btn-warning" data=mytitle data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--Delete Modal-->
    <div class="modal modal-danger fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" class="text-center" id="myModalLabel">Delete Confirmation</h4>
                </div>

                <form>
                   
                    <div class="modal-body">
                        <form>

                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <p class="text-center">Are you sure to delete?</p>
                            <input type="hidden"  id="user_id" name="user_id" value="">
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="deleteUser"><span class="glyphicon glyphicon-ok"></span> Yes, Delete</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </section>

 



@endsection