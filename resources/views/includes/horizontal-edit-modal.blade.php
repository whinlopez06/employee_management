<div class="modal fade" id="edit{{$title}}Modal" tabindex="-1" role="dialog" aria-labelledby="edit{{$title}}Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="edit{{$title}}ModalLabel">Update {{ isset($title) ? $title : '' }}</h4>
            </div>
    
            <div class="modal-body">
                <form class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    @include($formgroup)
                    {{ $slot }}
                </form>
            </div>
    
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="update{{$title}}">
                    <span class="glyphicon glyphicon-check"></span> Update
                </button>
                <button class="btn btn-warning" data=mytitle data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Close</button>
            </div>
        </div>
    </div>
</div>