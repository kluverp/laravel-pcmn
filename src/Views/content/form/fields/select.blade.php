@component('pcmn::content.form.fields.base', ['id' => $id, 'label' => $label])
<select class="form-control" id="{{ $id }}">
    @foreach($options as $option)
        <option value="{{ $option->getValue() }}" @if($option->isSelected($value)) selected="selected" @endif>{{ $option->getLabel() }}</option>
    @endforeach
</select>
<small class="form-text text-muted">{{ $helpText }}</small>
@endcomponent