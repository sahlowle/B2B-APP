{{-- Important Notice - positioned prominently before payment form --}}

<div class="text-center mb-3">
    <a class="btn btn-outline-warning btn-lg shadow-sm border-2 fw-semibold d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill" 
       data-bs-toggle="collapse" 
       href="#collapseExample" 
       role="button" 
       aria-expanded="false" 
       aria-controls="collapseExample"
       style="transition: all 0.3s ease; min-width: 300px;"
       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(255, 193, 7, 0.3)';"
       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)';">
        <i class="fas fa-exclamation-triangle text-warning"></i>
        <span>@lang('Important Notice Before Completing Payment')</span>
        <i class="fas fa-chevron-down ms-auto" style="transition: transform 0.3s ease;"></i>
    </a>
</div>


<div class="alert alert-warning border-warning mb-4 collapse" id="collapseExample">
    <div class="d-flex align-items-start">
        <div class="me-3">
            <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
        </div>
        <div class="flex-grow-1">
            <h6 class="alert-heading mb-2 fw-bold">
                @lang('Important Notice Before Completing Payment')
            </h6>
                    
            <ol class="mb-0 small">
                <li class="mb-1">
                    @lang('Ensure your') 
                    <strong>
                        @lang('bank card (Visa or MasterCard)')
                    </strong> 
                    @lang('balance covers the full subscription amount.')
                </li>
                
                <li class="mb-1"></li>
                    @lang('Verify that your') 
                    <strong>
                        @lang('daily or monthly purchase limit')
                    </strong> 
                    @lang('is higher than the subscription amount') (
                    <span class="fw-semibold">
                        {{ formatNumber($purchaseData->total) }}
                    </span>).
                </li>

                <li class="mb-1">
                    @lang('If the transaction is declined, it may be due to') 
                    <strong>
                        @lang('limit restrictions or online payment settings')
                    </strong> 
                    @lang('on your card.')
                </li>
                <li class="mb-1">
                    @lang('Contact your') 
                    <strong>
                        @lang('bank')
                    </strong> 
                    @lang('to temporarily increase the limit or enable online payments.')
                </li>
                <li class="mb-0">
                    @lang('If the issue persists, please') 
                    <strong>
                        @lang('try another card')
                    </strong> 
                    @lang('or payment method.')
                </li>
            </ol>
        </div>
    </div>
</div>
