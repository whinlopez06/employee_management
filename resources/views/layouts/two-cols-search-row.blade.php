<div class="row">

    @php
        $index = 0;   
    @endphp    

    @foreach($items as $item)
        <!--6 or half only because per two columns expected only-->
        <div class="col-md-6">
            <div class="form-group">

                @php
                    $stringFomat = ucwords(str_replace('search_', '', $item));   
                @endphp

                <label for="input<?= $stringFomat ?>" class="col-sm-3 control-label">{{ $stringFomat }}</label>

                <div class="col-sm-9">
                    <input type="text" value="{{ isset($oldVals) ? $oldVals[$index] : '' }}" class="form-control" 
                        id="<?= $item ?>" name="<?= $item ?>" placeholder="{{ $stringFomat }}">
                </div>

            </div>
        </div>

        @php
            $index++;   
        @endphp

    @endforeach

</div>