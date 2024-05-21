@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Forms</h1>
    <a href="{{ route('forms.create') }}" class="btn btn-primary mb-3">Create New Form</a>
    @if (count($forms) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                    <tr>
                        <td>{{ $form->name }}</td>
                        <td>
                            <a href="{{ route('forms.edit', $form->id) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('forms.destroy', $form->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No forms found.</p>
    @endif
</div>
@endsection
