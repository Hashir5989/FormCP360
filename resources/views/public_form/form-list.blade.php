@extends('layouts.public')

@section('content')
<div class="container">
    <h1>Forms</h1>
    <ul>
        @foreach ($forms as $form)
        <li><a href="{{ url('/form-list/' . $form->id) }}">{{ $form->name }}</a></li>
        @endforeach
    </ul>
</div>
@endsection