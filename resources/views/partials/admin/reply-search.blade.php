@if ($replies->isEmpty())
    <div class="alert alert-info text-info text-center">
        <h3>No replies found</h3>
    </div>
@endif

<div class="container">
    <div class="mx-auto w-75">
        <div class="form-group mb-2">
            <input type="text" class="form-control" id="search" aria-describedby="name"
                   placeholder="Search" value="" name="name" required>
        </div>
        <div class="text-center text-danger mb-2 mt-1" id="search-error"></div>
        <div class="d-grid gap-2 w-50 mx-auto mb-4">
            <button id="search_btn" class="btn btn-primary" type="button">Search</button>

            <div class="spinner-border text-info mx-auto d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>