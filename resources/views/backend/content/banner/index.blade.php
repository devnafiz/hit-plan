@extends('backend.layouts.app')

@section('title', __('Manage Banner'))

@section('content')

<x-backend.card xmlns:livewire="">
  <x-slot name="header">
    @lang('Manage Banner')
  </x-slot>

  <x-slot name="headerActions">
    <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.banner.create')"
      :text="__('New Banner')" />
  </x-slot>

  <x-slot name="body">
    <livewire:backend.banner-table />
  </x-slot>
</x-backend.card>

@endsection

@push('after-styles')
<livewire:styles />
@endpush

@push('after-scripts')
<livewire:scripts />
@endpush