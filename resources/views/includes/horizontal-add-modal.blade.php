<div class="modal fade" id="add{{$title}}Modal" tabindex="-1" role="dialog" aria-labelledby="add{{$title}}ModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addUserModal">Add New {{ isset($title) ? $title : '' }}</h4>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        @include($formgroup)
                    </form>
                </div>

                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="create{{$title}}">
                        <span class="glyphicon glyphicon-plus"></span> Create
                    </button>
                    <button class="btn btn-warning" data=mytitle data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Close</button>
                </div>

            </div>    
        </div>
    </div>