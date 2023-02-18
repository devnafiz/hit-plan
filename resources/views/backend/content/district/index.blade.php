@extends('backend.layouts.app')

@section('title', __('Manage District'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('Manage District')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.district.create')"
                :text="__('Register District')" />
        </x-slot>

        <x-slot name="body">
            <div class="row justify-content-center">
                <div class="col-md-12 col-sm-12">
                    <livewire:backend.district-table />
                </div>
            </div>
        </x-slot>
    </x-backend.card>

@endsection

@push('after-styles')
    <livewire:styles />
@endpush

@push('after-scripts')
    <livewire:scripts />
@endpush
