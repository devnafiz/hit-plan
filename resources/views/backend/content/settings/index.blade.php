@extends('backend.layouts.app')

@section('title', __('Manage Setting'))

@section('content')

    <x-backend.card xmlns:livewire="">
        <x-slot name="header">
            @lang('Manage site')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link-header icon="fas fa-plus" data-toggle="modal" data-target="#siteSettingModel"
                class="btn btn-sm btn-tool btn-primary" :text="__('Add setting')" />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.settings-table />
        </x-slot>
    </x-backend.card>
    <div class="modal fade bd-example-modal-lg" id="siteSettingModel" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Settings form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="site_settings_form" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="url" value="{{ route('admin.site_settings.store') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">App name</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="app_name" name="app_name" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">App name(short)</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="app_name_short" name="app_name_short" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">Email</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="app_email" name="app_email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">App URL</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="app_url" name="app_url" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">Logo</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" id="app_logo" name="app_logo" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">Fabicon</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" id="fabicon" name="fabicon" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">Footer text</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="footer_text" name="footer_text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">Company details</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="company_details" id="company_details" cols="20"
                                        rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-2">
                                    <label for="">Address</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="company_address" id="company_address" cols="20"
                                        rows="6"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-styles')
    <livewire:styles />
@endpush

@push('after-scripts')
    <livewire:scripts />
@endpush
