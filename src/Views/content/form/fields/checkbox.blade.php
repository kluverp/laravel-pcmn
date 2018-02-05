<fieldset class="form-group">
    <div class="row">
        <legend class="col-form-legend col-sm-2">{{ $label }}</legend>
        <div class="col-sm-10">

            {{--
            @foreach($options as $option)
                <div class="form-check">
                    <label class="form-check-label" for="{{ $id }}_{{ $loop->index }}">
                        <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $id }}_{{ $loop->index }}" value="{{ $option->getValue() }}" @if($option->isChecked($value, $loop->index)) checked="checked" @endif>
                        {{ $option->getLabel() }}
                    </label>
                </div>
            @endforeach
            --}}

        </div>
    </div>
</fieldset>
