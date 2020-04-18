@extends('layouts.app')

@section('content')
<div class="container mx-auto p-8">
    <livewire:search-events />
    <livewire:add-event-form />
</div>
@endsection
