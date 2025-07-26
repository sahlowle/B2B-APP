@extends('admin.layouts.app')
@section('page_title', __('Authentication Layout'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container authentication-layout-container">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Authentication Layout') }}</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('auth.layout.store') }}" method="post" class="product_setting_form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body border-bottom table-border-style p-0">
                        <div class="form-tabs">
                            <div class="tab-content box-shadow-unset px-0 py-2">
                                <div class="tab-pane fade show active" id="home"
                                    role="tabpanel" aria-labelledby="home-tab">

                                    <div class="form-group row">
                                        <label for="taxes"
                                            class="col-2 control-label">{{ __('Layout') }}</label>
                                        <div class="col-6 d-flex">
                                            <div class="container parent pe-1">
                                                <div class="row">
                                                    @foreach ($templates as $template)
                                                        <div class='col text-center col-4 mb-1 pe-0'>
                                                            <input type="radio" name="template" id="img_{{ $template }}" class="d-none imgbgchk" value="{{ $template }}" 
                                                                {{ preference('auth_template_name', 'template-1') == $template ? 'checked' : '' }}>
                                                            <label for="img_{{ $template }}">
                                                                <img src="{{ url('resources/views/admin/auth/login_templates/' . $template . '/thumbnail.png') }}" alt="Image">
                                                                <div class="tick_container">
                                                                    <div class="tick"><i class="fa fa-check"></i></div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="extra_content">
                                        @if (in_array('title', $authSettings[preference('auth_template_name', 'template-1')]['required']))
                                            <div class="form-group row">
                                                <label for="taxes"
                                                    class="col-2 control-label">{{ __('Title') }}</label>
                                                <div class="col-6 d-flex ms-2">
                                                    <input type="text" class="form-control inputFieldDesign" id="" name="title" value="{{ $authSettings[preference('auth_template_name', 'template-1')]['data']['title'] }}">
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if (in_array('description', $authSettings[preference('auth_template_name', 'template-1')]['required']))
                                            <div class="form-group row">
                                                <label for="taxes"
                                                    class="col-2 control-label">{{ __('Description') }}</label>
                                                <div class="col-6 d-flex ms-2">
                                                    <textarea rows="3" class="form-control" name="description">{{ $authSettings[preference('auth_template_name', 'template-1')]['data']['description'] }}</textarea>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if (in_array('file', $authSettings[preference('auth_template_name', 'template-1')]['required']))
                                            <div class="form-group row">
                                                <label class="control-label col-2 ltr:ps-3 rtl:pe-3">{{ __('Background') }}</label>
                                                <div class="col-sm-6 ms-2">
                                                    <div class="custom-file position-relative" data-val="single"
                                                        id="image-status">
                                                        <input class="form-control up-images attachment d-none" name="attachment"
                                                            id="validatedCustomFile" accept="image/*">
                                                        <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                            for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                    </div>
                                                    <div id="img-container">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="position-relative border boder-1 p-1 ltr:me-2 rtl:ms-2 rounded mt-2">
                                                                <img width="100px" class="upl-img object-fit-contain p-1"
                                                                    src="{{ url('resources/views/admin/auth/login_templates/' . preference('auth_template_name', 'template-1') . '/' . $authSettings[preference('auth_template_name', 'template-1')]['data']['file']) }}" alt="{{ __('Image') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0 d-flex justify-content-end">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12 pe-0">
                                <a href="{{ url('auth/login') . '?template=' . preference('auth_template_name', 'template-1') }}" 
                                    class="btn all-cancel-btn custom-btn-cancel ltr:float-right rtl:float-left px-3 me-0 preview-button" target="_blank">
                                    <span class="fa fa-eye">&nbsp;</span>
                                    {{ __('Preview') }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button"
                                    id="footer-btn">
                                    <span class="d-none product-spinner spinner-border spinner-border-sm text-secondary"
                                        role="status"></span>
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('mediamanager::image.modal_image')
@endsection

@section('js')
    <script>
        const authSettings = @json($authSettings);
        const url = '{{ url('/') }}';
    </script>
    <script src="{{ asset('Modules/CMS/Resources/assets/js/auth-layout.min.js') }}"></script>
@endsection
