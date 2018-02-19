@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
<input{!! $attr !!}>
@if($helpText)
    <small class="form-text text-muted">{{ $helpText }}</small>
@endif
@endcomponent
