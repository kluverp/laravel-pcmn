@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
    <input{!! $attr !!}>
    @if($helpText)
        <small class="form-text text-muted invalid-feedback">{{ $helpText }}</small>
    @endif
@endcomponent
