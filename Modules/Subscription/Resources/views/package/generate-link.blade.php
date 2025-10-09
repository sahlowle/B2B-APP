@extends('admin.layouts.app')
@section('page_title', __('Private Plan Link'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="package-list-container">
        <div class="card">
            <div class="card-header bb-none pb-2">
                <h5>{{ __('Private Plan Link') }}</h5>
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    <button class="btn btn-sm btn-mv-primary mb-0 ltr:me-1 rtl:ms-1 collapsed filterbtn" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="true"
                        aria-controls="filterPanel">
                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add New') }}
                    </button>
                </div>
            </div>
            <div class="card-header p-0 collapse" id="filterPanel">
                <div class="row mx-2 my-3">
                    <div class="container mt-2" id="v-pills-restriction" role="tabpanel"
                        aria-labelledby="v-pills-restriction-tab">
                        <form action="{{ route('package.generate.link') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $id }}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="user" class="col-2 control-label">{{ __('User') }}</label>
                                        <div class="col-6">
                                            <select class="form-control select2 inputFieldDesign" id="user_list">
                                                <option value="">{{ __('Select One') }}</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->email }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="user" class="col-2 control-label">{{ __('Email') }}</label>
                                        <div class="col-6">
                                            <input name="email" type="email" placeholder="{{ __('Email') }}"
                                                class="form-control form-width inputFieldDesign" id="user_email">
                                        </div>
                                    </div>

                                    <div class="form-group row m-0 my-md-3 d-felx mt-3">
                                        <div class="offset-2 col-3 ps-0">
                                            <input type="hidden" name="send_mail" value="0">
                                            <div class="checkbox checkbox-warning checkbox-fill d-inline">
                                                <input type="checkbox" class="form-control" name="send_mail"
                                                    id="checkbox-p-fill-1" value="1">
                                                <label for="checkbox-p-fill-1"
                                                    class="cr">{{ __('Send email to the user') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-3 pe-2">
                                            <div class="float-right me-0">
                                                <button type="submit"
                                                    class="btn custom-btn-submit package-submit-button me-0"
                                                    id="generate_link">{{ __('Generate Link') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <x-backend.datatable.table-wrapper class="product-table need-batch-operation"
                data-namespace="Modules\Subscription\Entities\PackageMeta" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection

@section('js')
    <script>
        const generateLinkUrl = "{{ route('package.generate.link') }}";
    </script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
