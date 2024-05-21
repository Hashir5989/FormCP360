@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Form</h1>
    <form action="{{ route('forms.store') }}" method="POST" id="createForm">
        @csrf
        <div class="form-group">
            <label for="name">Form Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        <h3>Form Fields</h3>
        <div id="fields-container">
            <div class="form-group field-row">
                <label for="label" class="pt-2">Field Label</label>
                <input type="text" name="fields[0][label][]" class="form-control" required>

                <label for="name" class="pt-2">Field Name</label>
                <input type="text" name="fields[0][name][]" class="form-control" required>

                <label for="type" class="pt-2">Field Type</label>
                <select name="fields[0][type][]" class="form-control field-type" data-index="0">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="select">Select</option>
                </select>
                <div class="form-group options-container" style="display: none;">
                    <label>Options</label>
                    <textarea name="fields[0][options][]" class="form-control"></textarea>
                    <small>Enter options separated by commas</small>
                </div>
                <div class="pt-3">
                    <button type="button" class="btn btn-danger remove-field pt-2">Remove</button>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <button type="button" class="btn btn-secondary" id="add-field">Add Field</button>
            <button type="submit" class="btn btn-primary">Save Form</button>
        </div>
    </form>
</div>

<script>
    let fieldIndex = 1;

    document.getElementById('add-field').addEventListener('click', function() {
        let fieldRow = document.createElement('div');
        fieldRow.classList.add('form-group', 'field-row');
        fieldRow.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <label for="label">Field Label</label>
                    <input type="text" name="fields[${fieldIndex}][label][]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="name">Field Name</label>
                    <input type="text" name="fields[${fieldIndex}][name][]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="type">Field Type</label>
                    <select name="fields[${fieldIndex}][type][]" class="form-control field-type" data-index="${fieldIndex}">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="select">Select</option>
                    </select>
                </div>
                <div class="col-md-3 options-container" style="display: none;">
                    <label>Options</label>
                    <textarea name="fields[${fieldIndex}][options][]" class="form-control"></textarea>
                    <small>Enter options separated by commas</small>
                </div>
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
            if (confirm("Are you sure you want to remove this field?")) {
                event.target.closest('.field-row').remove();
            }
        }
    });

    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('field-type')) {
            let index = event.target.getAttribute('data-index');
            let optionsContainer = event.target.closest('.field-row').querySelector('.options-container');
            if (event.target.value === 'select') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }
    });

    // Client-side validation
    document.getElementById('createForm').addEventListener('submit', function(event) {
        let labels = document.querySelectorAll('input[name^="fields[label]"]');
        let names = document.querySelectorAll('input[name^="fields[name]"]');
        let types = document.querySelectorAll('select[name^="fields[type]"]');
        for (let i = 0; i < labels.length; i++) {
            if (labels[i].value.trim() === '' || names[i].value.trim() === '') {
                alert('Field label and name cannot be empty.');
                event.preventDefault();
                return;
            }
        }
    });
</script>
@endsection