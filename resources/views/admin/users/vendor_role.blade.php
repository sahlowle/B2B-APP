@php
    $vendors = \App\Models\Vendor::getAll()->whereIn('id', $vendorIds);
    
    $user = \App\Models\User::find($userId);
    $vendorId = $vendorId ?? $vendors->first()->id;

    if (!empty($user) && !is_null($user->role()->vendor_id)) {
        $vendorId = $user->role()->vendor_id;
    }
    $roles = \App\Models\Role::getAll()->where('vendor_id', $vendorId);
@endphp

<div class="form-group row vendor">
  <label for="vendor_id"
      class="col-sm-2 control-label require">{{ __('Vendor') }} </label>
  <div class="col-sm-12">
      <select class="form-control select2-hide-search inputFieldDesign"
          name="vendor_id" id="vendor_id" required 
          oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">   
            @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}"
                    {{  (!empty($user) &&  $user->role()->vendor_id == $vendor->id) ? 'selected' : '' }}>
                    {{ $vendor->name }}</option>
            @endforeach
      </select>
  </div>
</div>

<div class="form-group row vendor role">
  <label for="vendor_role_id"
      class="col-sm-2 control-label require">{{ __('Vendor Role') }}</label>
  <div class="col-sm-12">
      <select class="form-control select2-hide-search inputFieldDesign"
          name="vendor_role_id[]" id="vendor_role_id" required
          oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
          @foreach ($roles as $role)
              <option value="{{ $role->id }}"
                  {{ ( !empty($user) &&  $user->role()->id == $role->id)  ? 'selected' : '' }}>
                  {{ $role->name }}</option>
          @endforeach
      </select>
  </div>
</div>




