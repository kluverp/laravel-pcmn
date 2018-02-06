@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
<textarea {!! $attr !!}>{!! $value !!}</textarea>
<small class="form-text text-muted">{{ $helpText }}</small>
@endcomponent