<div class="mt-1.5 relative overflow-hidden show-details">
    <div class="border-one pb-3">
        <h3 class="text-base roboto-medium font-medium text-gray-12 leading-5">
            {{ __('B2B') }}
        </h3>
    </div>
    <div class="mt-4">
        <div class="flex items-center c-check mb-5p">
            <input id="b2b-checkbox" type="checkbox" name="b2b" data-option="b2b" value="1" class="b2b-checkbox" {{ isset($res->records->filter_applied->b2b) && is_array($res->records->filter_applied->b2b) && in_array(1, $res->records->filter_applied->b2b) ? 'checked' : '' }}>
            <label for="b2b-checkbox" class="flex items-center ml-3 roboto-medium text-15 text-gray-10 cursor-pointer">
                {{ __('B2B Products Only') }}
            </label>
        </div>
    </div>

</div>
