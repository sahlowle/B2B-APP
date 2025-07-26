@if ($customFieldValues)
    <div class="card card-width order-details-customer-data">
        <div class="product-permissions-header accordion cursor_pointer">
            <span>{{ __('Customer Data') }}</span>
            <span class="drop-down-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 10" fill="none">
                    <path d="M6.80496 9.84648L12.7031 2.23935C13.3926 1.35009 12.8043 -9.56008e-07 11.7273 -9.68852e-07L1.27274 -1.09352e-06C0.195723 -1.10636e-06 -0.39263 1.35009 0.296859 2.23935L6.19504 9.84648C6.35375 10.0512 6.64626 10.0512 6.80496 9.84648Z" fill="white"/>
                    </svg>
            </span>
        </div>
        <br>
        <div id="customer_data">
            @foreach ($customFieldValues as $key => $value)
                <div class="row px-4 mt-2 mt-md-0">
                    <div class="col-md-3">
                        <p class="f-16 font-bold">{{ $key }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="f-16 text-dark">{!! $value !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
