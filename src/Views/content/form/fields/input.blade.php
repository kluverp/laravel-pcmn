@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
    @if(isset($prepend) || isset($append))
        <div class="input-group">@endif
            @if(isset($prepend))
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">{{ $prepend }}</span>
                </div>
            @endif
            <input{!! $attr !!}>
            @if(isset($append))
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">@example.com</span>
                </div>
            @endif
            @if(isset($prepend) || isset($append))</div>@endif
    @if($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @elseif($helpText)
        <small class="form-text text-muted">{{ $helpText }}</small>
    @endif
@endcomponent
