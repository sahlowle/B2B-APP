@extends('site.myaccount.layouts.master')
@section('page_title', __('Profile'))
@section('content')
    @php
        $user = auth()->user();
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="user_profile">
        <section>
            <p class="text-2xl text-black font-medium">{{ __("Profile") }}</p>
            <form method="post" action="{{ route('site.profile.update') }}" id="edit_user_profile_form" class="grid lg:grid-cols-2 grid-cols-1 gap-3" enctype="multipart/form-data">
                @csrf
                <div class="bg-neutral-100 p-5 lg:mt-2 mt-3 rounded-lg h-max">
                    <p class="text-gray-400 font-semibold text-sm leading-5">{{ __("PROFILE DISPLAY") }}</p>
                    <div class="flex mt-6">
                        <img class="lg:h-36 lg:w-36 h-24 w-24 rounded-full border-4 border-white" id="proPic"
                            src="{{ $user->fileUrl() }}" alt="your image" />
                        <div class="lg:mt-7 mt-1 text-center ltr:ml-6 rtl:mr-6">
                            <label class="flex cursor-pointer items-center justify-center lg:py-3.5 py-2.5 font-medium text-sm text-white whitespace-nowrap bg-black mb-2 rounded px-4"
                                for="imgInp"><input class="sr-only cursor-pointer" accept="image/*" type='file'
                                    id="imgInp" name="image" />{{ __('Change Image') }}</label>
                            <a href="javascript:void(0)"
                                data-url="{{ route('site.profile.delete') }}"
                                data-method="get"
                                class="dm-sans text-gray-500 font-medium lg:text-sm text-13 hover:text-gray-12 open-delete-modal">{{ __('Remove') }}</a>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="bg-neutral-100 p-5 lg:mt-2 rounded-lg">
                        <p class="text-gray-400 font-semibold text-sm leading-5">{{ __("PERSONAL INFORMATION") }}</p>
                        <div class="my-6">
                            <label class="text-sm font-normal capitalize text-black require-profile" for="name">
                                {{ __('Name') }}</label>
                            <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control mt-1.5" value="{{ old('name', $user->name) }}" type="text" name="name" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                        <div class="mb-6">
                            <label class="text-sm font-normal capitalize text-black require-profile" for="email">
                                {{ __('Email Address') }}</label>
                            <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control mt-1.5" readonly value="{{ old('email', $user->email) }}" type="email" name="email" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                        </div>
                        <div class="mb-6 set-dial">
                            <label class="text-sm font-normal capitalize text-black" for="phone">
                                {{ __('Phone Number') }}</label>
                            <input class="ltr:pl-5 border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5 ltr:text-left rtl:text-right" name="phone" type="tel" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="grid grid-cols-2 lg:gap-3 gap-2 mb-6">
                            <div class="gender-container">
                                <label class="text-sm font-normal capitalize text-black mb-1.5" for="select">{{ __('Gender') }}</label>
                                <select name="gender" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" class="border border-gray-300 rounded-lg w-full h-11 font-medium text-sm text-black form-control genderSelect">
                                    <option @selected($user->gender == 'Male') value="Male">{{ __('Male') }}</option>
                                    <option @selected($user->gender == 'Female') value="Female">{{ __('Female') }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-normal capitalize text-black" for="Date">{{ __('Date of Birth') }}</label>
                                <input class="border border-gray-300 rounded w-full h-11 uppercase font-medium text-sm text-gray-600 form-control focus:border-gray-300 px-2 mt-1.5" type="date" name="birthday" id="date" onkeydown="return false" value="{{ old('birthday', $user->birthday) }}">
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-normal capitalize text-black require-profile" for="address">{{ __('Address') }}</label>
                            <textarea name="address" class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control mt-1.5" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" rows="10">{{ old('address', $user->address) }}</textarea>
                        </div>
                        
                    </div>
                    <button class="text-sm px-6 py-2.5 whitespace-nowrap dm-sans font-medium text-black bg-yellow-400 hover:text-white hover:bg-black rounded mt-5">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </section>
        @include('site.myaccount.layouts.delete')
    </main>
@endsection
