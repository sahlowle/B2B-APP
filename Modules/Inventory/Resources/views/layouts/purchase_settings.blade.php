<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Manage cost summary') }}</h5>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row" id="myModal-body">
                        <div class="col-sm-12 m-t-10 p-2">
                            <table class="table" id="adjust_table">
                                <thead>
                                <tr>
                                    <th class="text-center w-5">{{ __('Adjustment') }}</th>
                                    <th class="text-center w-5">{{ __('Amount') }}</th>
                                    <th class="text-center w-5">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="adjustRowId-0" class="adjustFields">
                                  <tr>
                                      <td class="text-center">{{ __('Shipping') }}</td>
                                      <td class="text-center"><input name="shipping_amount" class="inputShipping inputFieldDesign form-control text-center positive-float-number" id="adjust_shipping_amount" type="text"  value="{{ $purchaseDetails->shipping_charge ?? 0 }}"></td>
                                      <td class="text-center padding_top_18px">
                                          <a href="javascript:void(0)" disabled><i class="fas fa-ban"></i></a>
                                      </td>
                                  </tr>

                                  @if (isset($adjustments['name']))
                                      @foreach($adjustments['name'] as $key => $adjust)
                                          <tr class="adjustRow">
                                              <td class="text-center">
                                                  <select class="form-control inputAdjustField" name="adjustment[name][]">
                                                      <option value="" @selected($adjust == '' ? 'selected' : '')>{{ __('Select One')  }}</option>
                                                      <option value="Custom Duty" @selected($adjust == 'Custom Duty' ? 'selected' : '')>{{ __('Custom Duty')  }}</option>
                                                      <option value="Discount" @selected($adjust == 'Discount' ? 'selected' : '')>{{ __('Discount')  }}</option>
                                                      <option value="Foreign Transaction Fee" @selected($adjust == 'Foreign Transaction Fee' ? 'selected' : '')>{{ __('Foreign Transaction Fee')  }}</option>
                                                      <option value="Freight Fee" @selected($adjust == 'Freight Fee' ? 'selected' : '')>{{ __('Freight Fee')  }}</option>
                                                      <option value="Insurance" @selected($adjust == 'Insurance' ? 'selected' : '')>{{ __('Insurance')  }}</option>
                                                      <option value="Rush Fee" @selected($adjust == 'Rush Fee' ? 'selected' : '')>{{ __('Rush Fee')  }}</option>
                                                      <option value="Surcharge" @selected($adjust == 'Surcharge' ? 'selected' : '')>{{ __('Surcharge')  }}</option>
                                                      <option value="Other" @selected($adjust == 'Other' ? 'selected' : '')>{{ __('Other')  }}</option>
                                                  </select>
                                              </td>
                                              <td class="text-center">
                                                  <input name="adjustment[amount][]" class="inputAdjustAmount inputFieldDesign form-control text-center positive-float-number" type="text"  value="{{ $adjustments['amount'][$key] }}">
                                              </td>
                                              <td class="text-center padding_top_18px">
                                                  <a href="javascript:void(0)" class="closeAdjust"><i class="feather icon-trash"></i></a>
                                              </td>
                                          </tr>
                                      @endforeach
                                  @endif
                                </tbody>
                            </table>
                            <a class="options-add-two mt-2" id="adjustmentBtn">{{ __('Add Adjustment') }}</a>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="btn_save" class="col-sm-3 control-label"></label>
                        <div class="col-sm-12">
                            <button type="button" id="adjustSave"
                                    class="btn py-2 custom-btn-submit {{ languageDirection() == 'ltr' ? 'float-right' : 'float-left' }}">{{ __('Save') }}</button>
                            <button type="button"
                                    class="py-2 custom-btn-cancel {{ languageDirection() == 'ltr' ? 'float-right me-2' : 'float-left ms-2' }}"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
