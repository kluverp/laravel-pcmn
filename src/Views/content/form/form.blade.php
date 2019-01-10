<form class="form-horizontal" action="{{ $action }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <input type="hidden" name="_method" value="{{ $method }}"/>
    @foreach($fields as $field)
        {!! $field->html() !!}
    @endforeach
    <hr>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">@lang('pcmn::content.submit')</button>
        </div>
    </div>
</form>