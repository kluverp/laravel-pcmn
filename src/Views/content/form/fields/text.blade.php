@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
<textarea {!! $attr !!}>{!! $value !!}</textarea>
@endcomponent