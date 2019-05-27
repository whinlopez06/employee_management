<!-- base template of seach field -->
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $title or 'Search'}}</h3>

        <!-- <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div> -->
    </div><!--/.box-header-->
    

    <div class="box-body">
    {{-- any information or component that is not bound on slot will be passed here. $slot is a reserved word--}}
        {{ $slot }}    
    </div>
    <!--/.box-body-->


    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            Search
        </button>
    </div>

</div>