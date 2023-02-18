@extends('backend.layouts.app')

@section('title', __('পদবী তৈরি'))

@section('content')

<x-backend.card xmlns:livewire="">
    <x-slot name="header">
        @lang('পদবী সমূহ')
    </x-slot>

    <x-slot name="headerActions">
        <x-utils.link-header icon="fas fa-plus" class="btn btn-sm btn-tool btn-primary" :href="route('admin.designation.create')" :text="__('পদবী তৈরি')" />
    </x-slot>

    <x-slot name="body">
        <div class="main-content">
            <section class="section">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>পদবী সমূহ</h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered responsive_table" id="tableExport" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>ক্র. নং</th>
                                                    
                                                    <th>পদবী নাম</th>
                                                    <th>পদবী বিস্তারিত</th>
                                                    <th>সিদ্ধান্ত </th>
                                                    
                                                        
                                                    <th>বিস্তারিত</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($designations as $k=>$val)
                                                <tr>
                                                    <td>{{$k+1}}</td>
                                                   
                                                    <td>{{ $val->name }}</td>
                                                    <td>{{ $val->details }}</td>
                                                     <td>{{ ($val->status==1)?'Active':'Deactive' }}</td>
                                                        
                                                    
                                                    <td> @include('backend.content.designation.includes.action')</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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