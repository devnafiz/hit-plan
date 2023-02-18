@extends('backend.layouts.app')

@section('title', __('মাস্টারপ্লান প্লট তৈরি'))

@section('content')

<x-backend.card xmlns:livewire="">
    <x-slot name="header">
        @lang('মাস্টারপ্লান প্লট সমূহ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.masterplan-plot.create')" :text="__('নতুন মাস্টারপ্লান প্লট যুক্ত')" />
    </x-slot>

    <x-slot name="body">
        <livewire:backend.masterplanplot-table />
    </x-slot>
</x-backend.card>

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush