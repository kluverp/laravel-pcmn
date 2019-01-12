@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
    <input{!! $attr !!}>
    @if($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @elseif($helpText)
        <small class="form-text text-muted">{{ $helpText }}</small>
    @endif
@endcomponent
