@extends('backend.layouts.app')

@section('title', __('লাইসেন্স ফি আদায়'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('আদায় কৃত লাইসেন্সে ফি সমুহ')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.agri-license-fees.create')"
                :text="__('ফি আদায় করুন')" />
        </x-slot>

        <x-slot name="body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            <livewire:backend.pondfeescollection-table />
        </x-slot>
    </x-backend.card>

@endsection

@push('after-styles')
    <livewire:styles />
@endpush

@push('after-scripts')
    <livewire:scripts />
@endpush
