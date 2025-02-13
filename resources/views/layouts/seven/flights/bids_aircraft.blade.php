<div class="modal fade" id="bidModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addBidLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bidModalLabel">{{ __('flights.aircraftbooking') }}</h5>
                <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select name="" id="aircraft_select" class="bid_aircraft form-control"></select>
            </div>
            <div class="modal-footer">
                <button type="button" id="without_aircraft" class="btn btn-secondary"
                    data-bs-dismiss="modal">{{ __('flights.dontbookaircraft') }}</button>
                <button type="button" id="with_aircraft" class="btn btn-primary"
                    data-bs-dismiss="modal">{{ __('flights.bookaircraft') }}</button>
            </div>
        </div>
    </div>
</div>
