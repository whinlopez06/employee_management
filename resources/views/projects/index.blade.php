@extends('layouts.master')

@section('content')

<div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Projects</h3>
            <div class="row">
                <button type="button" class="btn btn-primary btn-md pull-right" style="margin-right: 2em;" data-toggle="modal" data-target="#addModal">
                    <span class="glyphicon glyphicon-plus"></span> Add New
                </button>
                <!--<a class="btn btn-primary btn-md pull-right " style="margin-right: 2em;" data-toggle="modal" data-target="#addModal">Add New</a> -->
            </div> 
        </div><!--/box-header-->

        <div class="box-body">

            @include('inc.message')
            <table class="table table-responsive" id="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @if(count($projects))
                <tbody>
                    @foreach($projects as $project)
                    <tr class="project{{ $project->id }}">
                        <td>{{ $project->code }}</td>
                        <td>{{ $project->description }}</td>
                        <td>
                            <button class="btn btn-info" data-id="{{ $project->id }}" data-code="{{ $project->code }}"
                                data-description="{{ $project->description }}" data-toggle="modal" data-target="#editModal"><span class='glyphicon glyphicon-pencil'> </span> Edit</button>&nbsp;
                           
                                <button class="btn btn-danger" data-id="{{ $project->id }}" data-toggle="modal" data-target="#deleteModal">
                                <span class='glyphicon glyphicon-trash'> </span> Delete</button>
                           
                           <!-- <a class="btn btn-info" data-id="{{ $project->id }}" data-code="{{ $project->code }}" data-description="{{ $project->description }}"
                                     data-toggle="modal" data-target="#editModal"> <span class='glyphicon glyphicon-pencil'> </span> Edit</a>
                            <a class="btn btn-danger" data-id="{{ $project->id }}" data-toggle="modal" data-target="#deleteModal"> <span class='glyphicon glyphicon-trash'></span>Delete</a> -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @endif

            </table>
        </div>

    </div><!--/box-->
</div>

<!--Create Modal-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="addModalLabel">Add Project</h4>
        </div>

        <div class="modal-body">
            <form class="form-group">
                {{ csrf_field() }}
                @include('projects.form')
            </form>
        </div>

        <div class="modal-footer">
            <button class="btn btn-default" data=mytitle data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="createProject">
                <span class="glyphicon glyphicon-plus"></span> Create
            </button>
        </div>
     
        </div>
    </div>
</div>

<!--Edit Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="editModalLabel">Edit Project</h4>
        </div>

        <div class="modal-body">
            <form class="form-group">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                @include('projects.form')
                <input type="hidden" name="project_id" id="project_id">
            </form>
        </div>

        <div class="modal-footer">
            <button class="btn btn-default" data=mytitle data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="updateProject">
                <span class="glyphicon glyphicon-plus"></span> Update
            </button>
        </div>
        
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        // Add Modal
        $("#createProject").click(function(){
           
            $.ajax({
                type: 'POST',
                url:  "{{ url('projects') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'code': $('input[name=code]').val(),
                    'description': $('textarea[name=description]').val()
                },
                success: function(data){
                    //console.log(data);
                    if((data.errors)){
                        $('.error').removeClass('hidden');
                        $('.error').text(data.errors.code);
                        $('.error').text(data.errors.description);
                    }else{
                        $('.error').addClass('hidden');
                        //"<tr class='post" + data.id + "'>"+
                        $('#table').append(
                        "<tr>"+
                        "<td>" + data.code + "</td>"+
                        "<td>" + data.description + "</td>"+
                        "<td><button class='btn btn-info ' data-id='" + data.id + "' data-code='" + data.code + "' data-description='" + data.description + "' data-toggle='modal' data-target='#editModal'><span class='glyphicon glyphicon-pencil'> </span> Edit</button>&nbsp;"+
                        " <button class='btn btn-danger ' data-id='" + data.id + "' data-toggle='modal' data-target='#deleteModal'><span class='glyphicon glyphicon-trash'> </span> Delete</button></td>"+
                        "</tr>");

                    }
                }
            });

            $('#code').val('');
            $('#description').val('');

        });

        $('#editModal').on('show.bs.modal', function (event) {
            
            var button = $(event.relatedTarget); // Button that triggered the modal
            var project_id = button.data('id');
          
            var code = button.data('code'); // Extract info from data-* attributes
            var description = button.data('description');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this); // instance of the opened modal
            
            modal.find('.modal-body #code').val(code); // find the title input and put the value of the passed title inside
            modal.find('.modal-body #description').val(description); // find the title input and put the value of the passed description inside
            modal.find('.modal-body #project_id').val(project_id);
               
                
        });

        $('#updateProject').on('click', function(){
            var modal = $(this);
            //alert('updateProject click');
            //$(this).find('#editModal #code').val();
            //$(this).find('.modal-body #code').val();
            var code = $('#editModal').find('.modal-body #code').val();
            var description = $('#editModal').find('.modal-body #description').val()
            var project_id = $('#editModal').find('.modal-body #project_id').val()
            $.ajax({
                type: "POST",
                url: "{{ url('projects') }}/"+project_id,
                data: {
                    '_token': $('input[name=_token]').val(),
                    '_method': $('input[name=_method]').val(),
                    'code': code,
                    'description': description,
                    'project_id': project_id
                },success: function(data){
                    //console.log(data);

                    $('.project'+data.id).replaceWith(" "+
                    "<tr class='project" + data.id + "'>" + 
                    "<td>"+ data.code +"</td>" +
                    "<td>"+ data.description + "</td>" +
                    "<td><button class='btn btn-info' data-id='" + data.id + " data-code='" + data.code + 
                    "' data-description='" + data.description + "' data-toggle='modal' data-target='#editModal'>" +
                    "<span class='glyphicon glyphicon-pencil'> </span> Edit</button>&nbsp;"+
                    "<button class='btn btn-danger' data-id='" + data.id + "' data-toggle='modal' data-target='#deleteModal'>" +
                    "<span class='glyphicon glyphicon-trash'> </span> Delete</button> </td>"
                    );

                    // call modal close
                    $("#editModal .close").click()
                    //$("#your-modal-id").modal('hide');
                }
            });   

        }) ;   


    });
</script>


@endsection