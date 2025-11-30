<style>
     .card-header {
            padding: .5rem 1rem;
            margin-bottom: 0;
            background-color: rgba(0,0,0,.03);
            border-bottom: none;
        }

        .btn-light:focus {
            color: #212529;
            background-color: #e2e6ea;
            border-color: #dae0e5;
            box-shadow: 0 0 0 0.2rem rgba(216,217,219,.5);
        }

        .form-control{

          height: 50px;
    border: 2px solid #eee;
    border-radius: 6px;
    font-size: 14px;
        }

        .form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #039be5;
    outline: 0;
    box-shadow: none;

    }

    .input{

      position: relative;
    }

    .input i{

          position: absolute;
    top: 16px;
    left: 11px;
    color: #989898;
    }

    .input input{

      text-indent: 25px;
    }

    .card-text{

      font-size: 13px;
    margin-left: 6px;
    }

    .certificate-text{

      font-size: 12px;
    }

       
    .billing{
      font-size: 11px;
    }  

    .super-price{

          top: 0px;
    font-size: 22px;
    }

    .super-month{

          font-size: 11px;
    }


    .line{
      color: #bfbdbd;
    }

    .free-button{

          background: #1565c0;
    height: 52px;
    font-size: 15px;
    border-radius: 8px;
    }


    .payment-card-body{

    flex: 1 1 auto;
    padding: 24px 1rem !important;

    }
</style>

<form novalidate class="payment-form" >
    <div class="card-body payment-card-body">
        <input type="hidden" name="parent_form_id" value="subscriptionForm{{ $package->id }}">
        <span class="font-weight-normal card-text"> @lang('Holder Name') </span>
        <div class="input">
            <i class="fa fa-user"></i>
            <input type="text" class="form-control" placeholder="@lang('Holder Name')" name="holder_name" maxlength="100">
        </div>
        <span class="text-danger name-error"></span>

        <div class="mt-2 mb-3">
            <span class="font-weight-normal card-text"> @lang('Card Number') </span>
            <div class="input" dir="ltr">
                <i class="fa fa-credit-card"></i>
                <input type="text" class="form-control" placeholder="0000 0000 0000 0000" name="card_number" maxlength="19">
            </div>
            <span class="text-danger card-error"></span>
        </div>

        <div class="mt-2 mb-3">
            <div class="col-md-12">
                <span class="font-weight-normal card-text"> @lang('Expiry Date') </span>
                <div class="input">
                    <i class="fa fa-calendar"></i>
                    <input type="text" class="form-control" placeholder="MM/YY" name="expiry_date" maxlength="5">
                </div>
                <span class="text-danger expiry-error"></span>
            </div>
            
            <div class="col-md-12">
                <span class="font-weight-normal card-text">CVC/CVV</span>
                <div class="input">
                    <i class="fa fa-lock"></i>
                    <input type="text" class="form-control" placeholder="000" name="cvv" maxlength="4">
                </div>
                <span class="text-danger cvv-error"></span>
            </div>
        </div>

        
        <span class="text-muted certificate-text">
            <i class="fa fa-lock"></i> @lang('Your transaction is secured with ssl certificate')
        </span>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn" data-bs-dismiss="modal"> @lang('Close') </button>
        <button type="submit" class="btn btn-primary" > @lang('Add') </button>
    </div>
</form>
