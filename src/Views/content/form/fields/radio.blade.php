<div class="form-group row">
    <div class="col-sm-2">{{ $label }}</div>
    <div class="col-sm-10">
        @foreach($options as $option)
            <div class="form-check-inline">
                <label class="form-check-label" for="{{ $id }}_{{ $loop->index }}">
                    <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $id }}_{{ $loop->index }}"
                           value="{{ $option->getValue() }}"
                           @if($option->isChecked($value, $loop->index)) checked="checked" @endif>
                    {{ $option->getLabel() }}
                </label>
            </div>
        @endforeach
        <small class="form-text text-muted">{{ $helpText }}</small>
    </div>
</div>

