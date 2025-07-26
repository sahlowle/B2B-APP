<div class="col-md-6">
    <div class="card">
        <div class="table-card">
            <div class="row-table">
                <div class="col-auto py-5">
                    <i class="feather icon-map fa-6x"></i>
                </div>
                <div class="col">
                    <h3>{{ __('Import Geo Locale Data') }}</h3>
                    <p>{{ __('Seed your database with ease using our geo locale data import feature – streamline testing and development effortlessly.') }}</p>
                </div>
            </div>
        </div>
        <div class="border-top px-3 import-button">
            <a href="{{ route('geolocale.import') }}" class="d-flex justify-content-between align-items-center">
                <p class="pt-3">{{ __('Proceed to Import') }}</p>
                <i class="feather feather icon-arrow-right f-20 neg-transition-scale"></i>
            </a>
        </div>
    </div>
</div>
