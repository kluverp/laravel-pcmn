<form class="form-horizontal" action="" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    @foreach($fields as $field)
        {!! $field->html() !!}
    @endforeach
    <hr>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>