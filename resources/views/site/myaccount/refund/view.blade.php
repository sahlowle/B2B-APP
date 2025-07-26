@extends('site.myaccount.layouts.master')
@section('page_title', __('Refund Details'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
@endsection
@section('content')
    @php
        // $refund get from controller
        $refund = $refund->with(['orderDetail', 'refundReason'])->first();
        $refundProcesses = Modules\Refund\Entities\RefundProcess::where(['refund_id' => $id])->with(['user'])->get();
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="customer_refund_view">
        <section>
            <p class="text-2xl text-black font-medium">{{ __("Refund Details") }}</p>
            <p class="text-sm text-gray-500 font-medium mt-3">{{ __("Reference") }} : <span
                    class="text-red-500 font-semibold">{{ $refund->reference }}</span>
            </p>
            <div class="grid lg:grid-cols-2 grid-cols-1 gap-3">
                <div>
                    <div class="flex gap-6 mt-6">
                        <img class="h-32 w-32 rounded-lg border border-gray-100" id="proPic"
                            src="{{ $refund->getRefundImage() }}" alt="your image" />
                        <div>
                            @php
                                $color = ['Opened' => 'bg-gray-11 ; text-gray-10 ', 'In progress' => 'bg-green-2 ; text-green-1', 'Accepted' => 'bg-green-2 ; text-green-1', 'Declined' => 'bg-pinks-2 ; text-reds-3'];
                            @endphp
                            <span
                                class="rounded-3xl px-3 py-1   font-medium text-sm leading-5 {{ $color[$refund->status] }}">{{ $refund->status }}
                            </span>
                            <p class="text-black font-medium mt-2.5 break-words">
                                {{ trimWords(optional(optional($refund->orderDetail)->item)->name, 50) }}</p>
                            <p class="text-black font-medium mt-2">x {{ $refund->quantity_sent }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mt-5">
                        <div class="bg-neutral-100 rounded-lg p-3">
                            <p class="text-sm font-normal text-gray-500">{{ __("Amount") }}</p>
                            <p class="mt-1.5 text-black font-medium">{{ optional($refund->orderDetail)->price }}</p>
                        </div>
                        <div class="bg-neutral-100 rounded-lg p-3">
                            <p class="text-sm font-normal text-gray-500">{{ __("Seller") }}</p>
                            {{ $refund->orderDetail?->vendor?->name }}
                        </div>
                    </div>
                    <div class="bg-neutral-100 rounded-lg p-3 mt-2">
                        <p class="text-sm font-normal text-gray-500">{{ __("Refund Reason") }}</p>
                        <p class="mt-1.5 text-black font-medium break-words">{{ optional($refund->refundReason)->name }}</p>
                    </div>
                    @if($refund->objectFile()->get()->isNotEmpty())
                        <p class="text-sm font-normal text-gray-500 mt-5">{{ __("Uploaded images") }}</p>
                        <div class="flex justify-start items-center flex-wrap gap-2 mt-2.5">
                            @foreach ($refund->filesUrlold() as $file)
                                <div class="fixSize user-img-con">
                                    <a class="cursor_pointer" href='{{ $file }}' data-lightbox="image-1"> <img class="w-16 h-16 rounded border border-gray-100" src='{{ $file }}'></a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div>
                    <a class="text-sm font-normal text-gray-400 flex justify-end items-center gap-1 mb-1"
                        href="{{ route('site.refundRequest') }}"><svg class="neg-transition-scale" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.4688 3.52925C10.2085 3.2689 9.78634 3.2689 9.52599 3.52925L5.52599 7.52925C5.26564 7.7896 5.26564 8.21171 5.52599 8.47205L9.52599 12.4721C9.78634 12.7324 10.2085 12.7324 10.4688 12.4721C10.7291 12.2117 10.7291 11.7896 10.4688 11.5292L6.9402 8.00065L10.4688 4.47206C10.7291 4.21171 10.7291 3.7896 10.4688 3.52925Z"
                                fill="#898989" />
                        </svg>
                        {{ __("Back") }}
                    </a>
                    <div class="border border-gray-300 rounded-lg">
                        <h1 class="text-gray-400 font-semibold text-sm leading-5 border-b p-4">{{ __("CHAT WITH SELLER") }}</h1>
                        <div class="h-96 sidebar-scrollbar overflow-auto p-4 border-b border-gray-300">
                            @if($refundProcesses->count())
                                @foreach($refundProcesses as $process)
                                    @if (auth()->user()->id == $process->user->id)
                                        <div class="flex mb-4 gap-3">
                                            <div class="w-full">
                                                <p class="title text-sm font-medium text-gray-400 rtl:text-left ltr:text-right mb-1">
                                                    {{ (auth()->user()->role()->name == $process->user->role()->name) ? __('You') : $process->user->role()->name }}
                                                </p>
                                                <p class="m-0 bg-yellow-400 rounded p-3 message text-sm rtl:text-left ltr:text-right">
                                                    {{ $process->note }}</p>
                                                <p class="text-sm font-medium text-gray-400 rtl:text-left ltr:text-right mt-1">
                                                    {{ strtotime($process->created_at) < strtotime('-3 days') ? timeZoneFormatDate($process->created_at) : \Carbon\Carbon::parse($process->created_at)->diffForhumans() }}
                                                </p>
                                            </div>
                                            <img class="rounded-full h-11 w-11"
                                                src="{{ $process->user->fileUrl() }}"alt="">
                                        </div>
                                    @else
                                        <div class="flex mb-4 gap-3">
                                            <img class="rounded-full h-11 w-11"
                                                src="{{ $process->user->fileUrl() }}"alt="">
                                            <div class="w-full">
                                                <div class="text-sm font-medium text-gray-400 ltr:text-left rtl:text-right mb-1">
                                                    <span class="user-name">{{ optional($process->user)->name }}</span>
                                                </div>
                                                <p class="m-0 bg-neutral-100 rounded p-3 message text-sm ltr:text-left rtl:text-right">{{ $process->note }}</p>
                                                <p class="text-sm font-medium text-gray-400 ltr:text-left rtl:text-right mt-1">
                                                    {{ strtotime($process->created_at) < strtotime('-3 days') ? timeZoneFormatDate($process->created_at) : \Carbon\Carbon::parse($process->created_at)->diffForhumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <p class="text-center flex justify-center items-center text-red-500 text-sm h-full">{{ __("The conversation has not started yet.") }}</p>
                            @endif
                        </div>
                        @if (in_array($refund->status, ['Opened', 'In progress']))
                            <form action="{{ route('site.refundProcess') }}" method="post" class="p-3">
                                @csrf
                                <input type="hidden" name="refund_id" value="{{ $refund->id }}">
                                <textarea name="note" class="py-0 text-base overflow-y-scroll middle-sidebar-scroll font-light !text-black bg-white placeholder:text-black placeholder:text-sm placeholder:font-light bg-clip-padding !bg-no-repeat border !border-none mx-auto focus:text-black !focus:bg-white !focus:border-none !focus:outline-none px-0 !outline-none form-control w-full h-16" required="" name="message" placeholder="Type your message.."></textarea>
                                <span oninvalid="this.setCustomValidity('This field is required.')"></span>
                                <button type="submit" class="bg-black gap-1.5 w-max rounded-lg text-sm text-white font-semibold py-2 px-6 flex text-center font-Figtree leading-5 cursor-pointer" ><span>Reply</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('js')
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>
@endsection
