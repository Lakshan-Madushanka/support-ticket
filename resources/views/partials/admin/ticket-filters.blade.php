<div class="row admin-filters-wrapper justify-content-between">
    <div class="col-md-2">
        <select class="status-select fw-bold text-info" aria-label="Default select example">
            <option>All</option>
            @foreach(\App\Models\SupportTicket::STATUS as $status)
                <option
                        @if(request()->query('status'))
                                @selected(request()->query('status') == $status)
                        @endif
                        value="{{$status}}">{{\App\Services\SupportTicket\SupportTicketService::statusTextfromCode($status)}}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md align-self-center text-end">
        <label class="form-check-label me-4" for="inlineRadio1">Date:</label>
        <div class="form-check form-check-inline">
            <input class="date-check-input" type="radio" checked name="dateOrder" id="inlineRadio1" value="desc">
            <label class="form-check-label" for="inlineRadio1">Desc</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="date-check-input" type="radio" name="dateOrder" id="inlineRadio2" value="asc">
            <label class="form-check-label" for="inlineRadio2">Asc</label>
        </div>

    </div>
</div>