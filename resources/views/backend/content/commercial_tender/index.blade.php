@extends('backend.layouts.app')

@section('title', __('বাণিজ্যিক দরপত্র তৈরি'))

@section('content')

<x-backend.card xmlns:livewire="">
    <x-slot name="header">
        @lang('বাণিজ্যিক দরপত্র সমূহ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.commercial.create')" :text="__('দরপত্র তৈরি')" />
    </x-slot>

    <x-slot name="body">
        <livewire:backend.commercitialtender-table />
    </x-slot>
</x-backend.card>

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush