@extends('layouts.public')

@section('content')
<div class="container">
    <h1>{{ $form->name }}</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ url('/form/'.$form->id) }}" method="POST">
        @csrf
        @if (!is_null($form->fields))
        @php
        $fields = is_array($form->fields) ? $form->fields : json_decode($form->fields, true);
        @endphp
        @foreach ($fields as $field)
        <div class="form-group">
            <label>{{ $field['label'] }}</label>
            @if ($field['type'] === 'text')
            <input type="text" name="{{ $field['name'] }}" class="form-control">
            @elseif ($field['type'] === 'number')
            <input type="number" name="{{ $field['name'] }}" class="form-control">
            @elseif ($field['type'] === 'select')
            <select name="{{ $field['name'] }}" class="form-control">
                @php
                $options = is_array($field['options']) ? $field['options'] : explode(',', $field['options']);
                @endphp
                @foreach ($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @endif
        </div>
        @endforeach
        @else
        <p>No fields found for this form.</p>
        @endif
        <div class="pt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection