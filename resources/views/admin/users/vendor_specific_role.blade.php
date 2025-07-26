@php
    $roles = \App\Models\Role::getAll()->where('vendor_id', $vendorId);
@endphp

<div class="form-group row vendor role">
  <label for="vendor_role_id"
      class="col-sm-2 control-label require">{{ __('Vendor Role') }}</label>
  <div class="col-sm-12">
      <select class="form-control select2-hide-search inputFieldDesign"
          name="vendor_role_id[]" id="vendor_role_id" required
          oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
          @foreach ($roles as $role)
              <option value="{{ $role->id }}"
                  {{ old('vendor_role_id') == $role->id ? 'selected' : '' }}>
                  {{ $role->name }}</option>
          @endforeach
      </select>
  </div>
</div>


