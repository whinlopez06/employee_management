@extends('layouts.master')


@section('content')      


<div >
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Categories</h3>
            <div class="row">
                <button type="button" class="btn btn-primary btn-md pull-right" style="margin-right: 2em;" data-toggle="modal" data-target="#addModal">
                        Add New
                </button>
            </div>
        </div><!--/box-header-->

        <div class="box-body">
            @include('inc.message')
          
                <table class="table table-responsive"> 
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>   
                        </tr>
                    </thead>
                    @if(count($categories))
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$category->title}}</td>
                                <td>{{$category->description}}</td>
                                <td>
                                    <!--define data attributes to pass information-->
                                    <button class="btn btn-info" data-category_id="{{ $category->id }}" data-mytitle="{{ $category->title }}" data-mydescription="{{ $category->description}}" 
                                        data-toggle="modal" data-target="#editModal">Edit</button>&nbsp;
                                    <button class="btn btn-danger" data-category_id="{{ $category->id }}" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
        
        </div><!--/box-body-->


    </div><!--/box-->
    
</div><!--/container-->



<!-- Button trigger modal -->





  <!--Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="addModalLabel">Add Category</h4>
        </div>
        <form action="{{route('category.store')}}" method="POST">
            {{ csrf_field() }}
            <div class="modal-body">

                @include('category.form')

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data=mytitle data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
      </div>
    </div>
</div>
<!--/Add Modal -->


<!--Edit Modal-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
            </div>
            <form id="editForm" action="" method="POST">
                <input type="hidden" id="updateUrl" value="{{ route('category.update', '') }}">
                <div class="modal-body">

                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    @include('category.form')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
          </div>
        </div>
    </div>
<!--/Edit Modal-->

<!--Delete Modal-->
<div class="modal modal-danger fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" class="text-center" id="myModalLabel">Delete Confirmation</h4>
        </div>
        <form id="deleteForm" action="" method="POST">
            <input type="hidden" id="deleteUrl" value="{{ route('category.destroy', '') }}">
            <div class="modal-body">

                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                
                <p class="text-center">Are you sure to delete?</p>
                <input type="hidden"  id="category_id" name="category_id" value="">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">No, Cancel</button>
                <button type="submit" class="btn btn-warning">Yes, Delete</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!--/delete modal-->



<script>
        $(document).ready(function(){
         
            $('#editModal').on('show.bs.modal', function (event) {
                //alert($("#editForm").attr('action'));
                //$("#editForm").attr('action', 'http://adminltecrud.local/test1');
           
                var button = $(event.relatedTarget); // Button that triggered the modal
                var category_id = button.data('category_id');
                var title = button.data('mytitle'); // Extract info from data-* attributes
                var description = button.data('mydescription');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this); // instance of the opened modal
                
                modal.find('.modal-body #title').val(title); // find the title input and put the value of the passed title inside
                modal.find('.modal-body #description').val(description); // find the title input and put the value of the passed description inside
                modal.find('.modal-body #category_id').val(category_id);
                $("#editForm").attr('action', $("#updateUrl").val() +'/' +category_id);
                
            });


            $('#deleteModal').on('show.bs.modal', function (event) {
                
                var button = $(event.relatedTarget);
                var category_id = button.data('category_id')
                modal.find('.modal-body #category_id').val(category_id);
                $("#deleteForm").attr('action', $("#deleteUrl").val() +'/' +category_id);
                
            });
 
        });
</script>

@endsection

