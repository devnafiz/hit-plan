@extends('backend.layouts.app')

@section('title', __('ইনভেনটরী তৈরি'))

@section('content')

<x-backend.card xmlns:livewire="">
    <x-slot name="header">
        @lang('ইনভেনটরী সমূহ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.inventory.create')" :text="__('ইনভেনটরী তৈরি')" />
    </x-slot>

    <x-slot name="body">
        <livewire:backend.inventory-table />
    </x-slot>
</x-backend.card>

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush