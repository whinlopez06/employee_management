<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addModalLabel">Add User</h4>
            </div>

            <div class="modal-body">
                {{ $bladefile }}
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="createProject">
                    <span class="glyphicon glyphicon-plus"></span> Create
                </button>
                <button class="btn btn-default" data=mytitle data-dismiss="modal">Close</button>
            </div>

        </div>    
    </div>
</div>