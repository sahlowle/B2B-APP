@php
    $b2bData = isset($variation) ? $variation->getB2BData() : [];
@endphp
<div id="{{ $b2bId }}"
     class="enable_b2b form-group row px-7 mt-20p collapse {{ $variation->meta_enable_b2b == '1' ? 'show' : '' }}">
    <div class="b2b_div">
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex align-items-center">
                    <label class="sp-title control-label">{{ __('Min Qty') }}</label>
                    <div class="tooltips {{ languageDirection() == 'ltr' ? 'ms-2' : 'me-2' }} cursor-pointer">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z" fill="#898989"></path>
                        </svg>
                        <span class="tooltiptexts">{{ __('If this is simple or variable product, this minimum quantity will apply on product price.') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex align-items-center">
                    <label class="sp-title control-label">{{ __('Max Qty') }}</label>
                    <div class="tooltips {{ languageDirection() == 'ltr' ? 'ms-2' : 'me-2' }} cursor-pointer">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z" fill="#898989"></path>
                        </svg>
                        <span class="tooltiptexts">{{ __('If this is simple or variable product, this maximum quantity will apply on product price.') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex align-items-center">
                    <label class="sp-title control-label">{{ __('B2B prices') }}</label>
                    <div class="tooltips {{ languageDirection() == 'ltr' ? 'ms-2' : 'me-2' }} cursor-pointer">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z" fill="#898989"></path>
                        </svg>
                        <span class="tooltiptexts">{{ __('This is price will apply depend on min & max condition.') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex align-items-center">
                    <label class="sp-title control-label">{{ __('Action') }}</label>
                    <div class="tooltips {{ languageDirection() == 'ltr' ? 'ms-2' : 'me-2' }} cursor-pointer">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6C12 9.31371 9.31371 12 6 12C2.68629 12 0 9.31371 0 6C0 2.68629 2.68629 0 6 0C9.31371 0 12 2.68629 12 6ZM6.66667 10C6.66667 10.3682 6.36819 10.6667 6 10.6667C5.63181 10.6667 5.33333 10.3682 5.33333 10C5.33333 9.63181 5.63181 9.33333 6 9.33333C6.36819 9.33333 6.66667 9.63181 6.66667 10ZM6 1.33333C4.52724 1.33333 3.33333 2.52724 3.33333 4H4.66667C4.66667 3.26362 5.26362 2.66667 6 2.66667H6.06287C6.76453 2.66667 7.33333 3.23547 7.33333 3.93713V4.27924C7.33333 4.62178 7.11414 4.92589 6.78918 5.03421C5.91976 5.32402 5.33333 6.13765 5.33333 7.05409V8.66667H6.66667V7.05409C6.66667 6.71155 6.88586 6.40744 7.21082 6.29912C8.08024 6.00932 8.66667 5.19569 8.66667 4.27924V3.93713C8.66667 2.49909 7.50091 1.33333 6.06287 1.33333H6Z" fill="#898989"></path>
                        </svg>
                        <span class="tooltiptexts">{{ __('This is use for delete B2B data.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @forelse ($b2bData as $b2b)
            <div class="row b2b_row">
                <div class="col-md-3 pb-4p">
                    <input type="number" placeholder="0" class="form-control inputFieldDesign min_qty" maxlength="8" name="meta_b2b_data[{{ $idx }}][{{ $loop->index }}][min_qty]" value="{{ isset($b2b['min_qty']) ? $b2b['min_qty'] : '' }}">
                </div>
                <div class="col-md-3 pb-4p">
                    <input type="number" placeholder="0" class="form-control inputFieldDesign max_qty" maxlength="8" name="meta_b2b_data[{{ $idx }}][{{ $loop->index }}][max_qty]" value="{{ isset($b2b['max_qty']) ? $b2b['max_qty'] : '' }}">
                </div>
                <div class="col-md-3 pb-4p">
                    <input type="number" placeholder="0" class="form-control inputFieldDesign" maxlength="8" name="meta_b2b_data[{{ $idx }}][{{ $loop->index }}][price]" value="{{ isset($b2b['price']) ? $b2b['price'] : '' }}">
                </div>
                <div class="col-md-3 pb-4p">
                    @if($loop->first)
                        <svg class="position-absolute mt-14p ml-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity=".05" fill-rule="evenodd" clip-rule="evenodd" d="M6.78296 13.376C8.73904 9.95284 8.73904 5.04719 6.78296 1.62405L7.21708 1.37598C9.261 4.95283 9.261 10.0472 7.21708 13.624L6.78296 13.376Z" fill="currentColor" /> <path opacity=".1" fill-rule="evenodd" clip-rule="evenodd" d="M7.28204 13.4775C9.23929 9.99523 9.23929 5.00475 7.28204 1.52248L7.71791 1.2775C9.76067 4.9119 9.76067 10.0881 7.71791 13.7225L7.28204 13.4775Z" fill="currentColor" /> <path opacity=".15" fill-rule="evenodd" clip-rule="evenodd" d="M7.82098 13.5064C9.72502 9.99523 9.72636 5.01411 7.82492 1.50084L8.26465 1.26285C10.2465 4.92466 10.2451 10.085 8.26052 13.7448L7.82098 13.5064Z" fill="currentColor" /> <path opacity=".2" fill-rule="evenodd" clip-rule="evenodd" d="M8.41284 13.429C10.1952 9.92842 10.1957 5.07537 8.41435 1.57402L8.85999 1.34729C10.7139 4.99113 10.7133 10.0128 8.85841 13.6559L8.41284 13.429Z" fill="currentColor" /> <path opacity=".25" fill-rule="evenodd" clip-rule="evenodd" d="M9.02441 13.2956C10.6567 9.8379 10.6586 5.17715 9.03005 1.71656L9.48245 1.50366C11.1745 5.09919 11.1726 9.91629 9.47657 13.5091L9.02441 13.2956Z" fill="currentColor" /> <path opacity=".3" fill-rule="evenodd" clip-rule="evenodd" d="M9.66809 13.0655C11.1097 9.69572 11.1107 5.3121 9.67088 1.94095L10.1307 1.74457C11.6241 5.24121 11.6231 9.76683 10.1278 13.2622L9.66809 13.0655Z" fill="currentColor" /> <path opacity=".35" fill-rule="evenodd" clip-rule="evenodd" d="M10.331 12.7456C11.5551 9.52073 11.5564 5.49103 10.3347 2.26444L10.8024 2.0874C12.0672 5.42815 12.0659 9.58394 10.7985 12.9231L10.331 12.7456Z" fill="currentColor" /> <path opacity=".4" fill-rule="evenodd" clip-rule="evenodd" d="M11.0155 12.2986C11.9938 9.29744 11.9948 5.71296 11.0184 2.71067L11.4939 2.55603C12.503 5.6589 12.502 9.35178 11.4909 12.4535L11.0155 12.2986Z" fill="currentColor" /> <path opacity=".45" fill-rule="evenodd" clip-rule="evenodd" d="M11.7214 11.668C12.4254 9.01303 12.4262 5.99691 11.7237 3.34116L12.2071 3.21329C12.9318 5.95292 12.931 9.05728 12.2047 11.7961L11.7214 11.668Z" fill="currentColor" /> <path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M12.4432 10.752C12.8524 8.63762 12.8523 6.36089 12.4429 4.2466L12.9338 4.15155C13.3553 6.32861 13.3554 8.66985 12.9341 10.847L12.4432 10.752Z" fill="currentColor" /> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.49991 0.877045C3.84222 0.877045 0.877075 3.84219 0.877075 7.49988C0.877075 9.1488 1.47969 10.657 2.4767 11.8162L1.64647 12.6464C1.45121 12.8417 1.45121 13.1583 1.64647 13.3535C1.84173 13.5488 2.15832 13.5488 2.35358 13.3535L3.18383 12.5233C4.34302 13.5202 5.8511 14.1227 7.49991 14.1227C11.1576 14.1227 14.1227 11.1575 14.1227 7.49988C14.1227 5.85107 13.5202 4.34298 12.5233 3.1838L13.3536 2.35355C13.5488 2.15829 13.5488 1.8417 13.3536 1.64644C13.1583 1.45118 12.8417 1.45118 12.6465 1.64644L11.8162 2.47667C10.657 1.47966 9.14883 0.877045 7.49991 0.877045ZM11.1423 3.15065C10.1568 2.32449 8.88644 1.82704 7.49991 1.82704C4.36689 1.82704 1.82708 4.36686 1.82708 7.49988C1.82708 8.88641 2.32452 10.1568 3.15069 11.1422L11.1423 3.15065ZM3.85781 11.8493C4.84322 12.6753 6.11348 13.1727 7.49991 13.1727C10.6329 13.1727 13.1727 10.6329 13.1727 7.49988C13.1727 6.11345 12.6754 4.84319 11.8493 3.85778L3.85781 11.8493Z" fill="currentColor" /> </svg>
                    @else
                        <svg class="delete_b2b position-absolute mt-14p ml-3"
                             width="8" height="8" viewBox="0 0 8 8"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M0.292893 0.292893C0.683417 -0.0976311 1.31658 -0.0976311 1.70711 0.292893L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976311 1.31658 -0.0976311 0.683417 0.292893 0.292893Z"
                                  fill="#898989"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M7.70711 0.292893C7.31658 -0.0976311 6.68342 -0.0976311 6.29289 0.292893L0.292893 6.29289C-0.0976315 6.68342 -0.0976315 7.31658 0.292893 7.70711C0.683417 8.09763 1.31658 8.09763 1.70711 7.70711L7.70711 1.70711C8.09763 1.31658 8.09763 0.683417 7.70711 0.292893Z"
                                  fill="#898989"></path>
                        </svg>
                    @endif
                </div>
            </div>
        @empty
            <div class="row b2b_row">
                <div class="col-md-3 pb-4p">
                    <input type="number" placeholder="0" class="form-control inputFieldDesign min_qty" maxlength="8" name="meta_b2b_data[{{ $idx }}][0][min_qty]" value="{{ isset($product) ? $product->meta_b2b_min_qty : '' }}">
                </div>
                <div class="col-md-3 pb-4p">
                    <input type="number" placeholder="0" class="form-control inputFieldDesign max_qty" maxlength="8" name="meta_b2b_data[{{ $idx }}][0][max_qty]" value="{{ isset($product) ? $product->meta_b2b_max_qty : '' }}">
                </div>
                <div class="col-md-3 pb-4p">
                    <input type="number" placeholder="0" class="form-control inputFieldDesign" maxlength="8" name="meta_b2b_data[{{ $idx }}][0][price]" value="{{ isset($product) ? $product->meta_b2b_price : '' }}">
                </div>
                <div class="col-md-3 pb-4p">
                    <svg class="position-absolute mt-14p {{ languageDirection() == 'ltr' ? 'ml-2' : 'me-3' }}" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity=".05" fill-rule="evenodd" clip-rule="evenodd" d="M6.78296 13.376C8.73904 9.95284 8.73904 5.04719 6.78296 1.62405L7.21708 1.37598C9.261 4.95283 9.261 10.0472 7.21708 13.624L6.78296 13.376Z" fill="currentColor" /> <path opacity=".1" fill-rule="evenodd" clip-rule="evenodd" d="M7.28204 13.4775C9.23929 9.99523 9.23929 5.00475 7.28204 1.52248L7.71791 1.2775C9.76067 4.9119 9.76067 10.0881 7.71791 13.7225L7.28204 13.4775Z" fill="currentColor" /> <path opacity=".15" fill-rule="evenodd" clip-rule="evenodd" d="M7.82098 13.5064C9.72502 9.99523 9.72636 5.01411 7.82492 1.50084L8.26465 1.26285C10.2465 4.92466 10.2451 10.085 8.26052 13.7448L7.82098 13.5064Z" fill="currentColor" /> <path opacity=".2" fill-rule="evenodd" clip-rule="evenodd" d="M8.41284 13.429C10.1952 9.92842 10.1957 5.07537 8.41435 1.57402L8.85999 1.34729C10.7139 4.99113 10.7133 10.0128 8.85841 13.6559L8.41284 13.429Z" fill="currentColor" /> <path opacity=".25" fill-rule="evenodd" clip-rule="evenodd" d="M9.02441 13.2956C10.6567 9.8379 10.6586 5.17715 9.03005 1.71656L9.48245 1.50366C11.1745 5.09919 11.1726 9.91629 9.47657 13.5091L9.02441 13.2956Z" fill="currentColor" /> <path opacity=".3" fill-rule="evenodd" clip-rule="evenodd" d="M9.66809 13.0655C11.1097 9.69572 11.1107 5.3121 9.67088 1.94095L10.1307 1.74457C11.6241 5.24121 11.6231 9.76683 10.1278 13.2622L9.66809 13.0655Z" fill="currentColor" /> <path opacity=".35" fill-rule="evenodd" clip-rule="evenodd" d="M10.331 12.7456C11.5551 9.52073 11.5564 5.49103 10.3347 2.26444L10.8024 2.0874C12.0672 5.42815 12.0659 9.58394 10.7985 12.9231L10.331 12.7456Z" fill="currentColor" /> <path opacity=".4" fill-rule="evenodd" clip-rule="evenodd" d="M11.0155 12.2986C11.9938 9.29744 11.9948 5.71296 11.0184 2.71067L11.4939 2.55603C12.503 5.6589 12.502 9.35178 11.4909 12.4535L11.0155 12.2986Z" fill="currentColor" /> <path opacity=".45" fill-rule="evenodd" clip-rule="evenodd" d="M11.7214 11.668C12.4254 9.01303 12.4262 5.99691 11.7237 3.34116L12.2071 3.21329C12.9318 5.95292 12.931 9.05728 12.2047 11.7961L11.7214 11.668Z" fill="currentColor" /> <path opacity=".5" fill-rule="evenodd" clip-rule="evenodd" d="M12.4432 10.752C12.8524 8.63762 12.8523 6.36089 12.4429 4.2466L12.9338 4.15155C13.3553 6.32861 13.3554 8.66985 12.9341 10.847L12.4432 10.752Z" fill="currentColor" /> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.49991 0.877045C3.84222 0.877045 0.877075 3.84219 0.877075 7.49988C0.877075 9.1488 1.47969 10.657 2.4767 11.8162L1.64647 12.6464C1.45121 12.8417 1.45121 13.1583 1.64647 13.3535C1.84173 13.5488 2.15832 13.5488 2.35358 13.3535L3.18383 12.5233C4.34302 13.5202 5.8511 14.1227 7.49991 14.1227C11.1576 14.1227 14.1227 11.1575 14.1227 7.49988C14.1227 5.85107 13.5202 4.34298 12.5233 3.1838L13.3536 2.35355C13.5488 2.15829 13.5488 1.8417 13.3536 1.64644C13.1583 1.45118 12.8417 1.45118 12.6465 1.64644L11.8162 2.47667C10.657 1.47966 9.14883 0.877045 7.49991 0.877045ZM11.1423 3.15065C10.1568 2.32449 8.88644 1.82704 7.49991 1.82704C4.36689 1.82704 1.82708 4.36686 1.82708 7.49988C1.82708 8.88641 2.32452 10.1568 3.15069 11.1422L11.1423 3.15065ZM3.85781 11.8493C4.84322 12.6753 6.11348 13.1727 7.49991 13.1727C10.6329 13.1727 13.1727 10.6329 13.1727 7.49988C13.1727 6.11345 12.6754 4.84319 11.8493 3.85778L3.85781 11.8493Z" fill="currentColor" /> </svg>
                </div>
            </div>
        @endforelse
    </div>
    <a class="options-add-two mt-2 add-b2b ml-10p" data-idx="{{ '[' . $idx . ']' }}">
        {{ __('Add More') }}
    </a>
</div>
