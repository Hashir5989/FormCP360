@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Form</h1>
    <form action="{{ route('forms.update', $form->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Form Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $form->name }}" required>
        </div>
        
        <h3>Form Fields</h3>
        <div id="fields-container">
            @php
                $fields = $form->fields ?? [];
                if (is_string($fields)) {
                    $fields = json_decode($fields, true) ?? [];
                }
            @endphp

            @foreach ($fields as $index => $field)
                <div class="form-group field-row">
                    <label for="label">Field Label</label>
                    <input type="text" name="fields[{{ $index }}][label]" class="form-control" value="{{ $field['label'] ?? '' }}" required>
                    
                    <label for="name" class="pt-2">Field Name</label>
                    <input type="text" name="fields[{{ $index }}][name]" class="form-control" value="{{ $field['name'] ?? '' }}" required>
                    
                    <label for="type" class="pt-2">Field Type</label>
                    <select name="fields[{{ $index }}][type]" class="form-control field-type" data-index="{{ $index }}">
                        <option value="text" {{ (isset($field['type']) && $field['type'] === 'text') ? 'selected' : '' }}>Text</option>
                        <option value="number" {{ (isset($field['type']) && $field['type'] === 'number') ? 'selected' : '' }}>Number</option>
                        <option value="select" {{ (isset($field['type']) && $field['type'] === 'select') ? 'selected' : '' }}>Select</option>
                    </select>
                    
                    <div class="form-group options-container pt-2" data-index="{{ $index }}" style="display: {{ (isset($field['type']) && $field['type'] === 'select') ? 'block' : 'none' }};">
                        <label>Options</label>
                        <textarea name="fields[{{ $index }}][options]" class="form-control">{{ $field['options'] ?? '' }}</textarea>
                        <small>Enter options separated by commas</small>
                    </div>
                    <div class="pt-3">
                    <button type="button" class="btn btn-danger remove-field pt-2">Remove</button>
            </div>
                </div>
            @endforeach
        </div>
        <div class="pt-3">
        <button type="button" class="btn btn-secondary" id="add-field">Add Field</button>
        <button type="submit" class="btn btn-primary">Update Form</button>
            </div>
    </form>
</div>

<script>
    let fieldIndex = {{ count($fields) }};
    document.getElementById('add-field').addEventListener('click', function() {
        let fieldRow = document.createElement('div');
        fieldRow.classList.add('form-group', 'field-row');
        fieldRow.innerHTML = `
            <label for="label" class="pt-2">Field Label</label>
            <input type="text" name="fields[${fieldIndex}][label]" class="form-control" required>
            
            <label for="name" class="pt-2">Field Name</label>
            <input type="text" name="fields[${fieldIndex}][name]" class="form-control" required>
            
            <label for="type" class="pt-2">Field Type</label>
            <select name="fields[${fieldIndex}][type]" class="form-control field-type" data-index="${fieldIndex}">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="select">Select</option>
            </select>
            
            <div class="form-group options-container pt-2" data-index="${fieldIndex}" style="display: none;">
                <label>Options</label>
                <textarea name="fields[${fieldIndex}][options]" class="form-control"></textarea>
                <small>Enter options separated by commas</small>
            </div>
            <div class="pt-3">
            <button type="button" class="btn btn-danger remove-field">Remove</button>
            </div>
        `;
        document.getElementById('fields-container').appendChild(fieldRow);
        fieldIndex++;
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-field')) {
            event.target.closest('.field-row').remove();
        }
    });

    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('field-type')) {
            let index = event.target.getAttribute('data-index');
            let optionsContainer = document.querySelector(`.options-container[data-index="${index}"]`);
            if (event.target.value === 'select') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }
    });
</script>
@endsection