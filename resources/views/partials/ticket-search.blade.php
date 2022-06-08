<div class="container">
    <div class="mx-auto w-75">
        <div class="form-group mb-2">
            <input type="text" class="form-control" id="search" aria-describedby="name"
                   placeholder="Search" value="" name="name" required>
        </div>
        <div class="text-center text-danger mb-2 mt-1" id="search-error"></div>
        {{--<div class="d-grid gap-2 mb-4">
            <button id="search_btn" class="btn btn-primary  mx-auto" type="button">Search</button>

            <div class="spinner-border text-info mx-auto d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>--}}
        <div class="d-grid gap-2 w-50 mx-auto mb-4">
            <button id="search_btn" class="btn btn-primary" type="button">Search</button>
        </div>
    </div>
</div>

@push('script')
{{--        <script src="{{asset('js/support-ticket-index.js') }}"></script>--}}
   {{-- <script>
        $(function () {
            $('#search_btn').on({
                'click': function () {
                    loadContent()
                },
                'keypress': function (event) {
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode == 13) {
                        loadContent();
                    }
                }
            })

            $('#search').on({
                'keypress': function (event) {
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode == 13) {
                        loadContent();
                    }
                }
            })

            function loadContent() {
                toggleLoader();
                console.log('alal')

                let value = $('#search').val();
                let currentUrl = window.location.href;

                if (value.trim() === '') {
                    $('#search-error').text('Please enter search string')
                    return;
                }

                const params = new URLSearchParams({
                    value: value,
                });
                let route = "/support-tickets/search" + '?' + params;

                if (currentUrl.includes('search-by-id')) {
                    route = "/support-tickets/search-by-id" + '?' + params;
                }

                $('body').load(route + " #main-wrapper, script", function () {
                    $('#search').val(value);
                    $('#title').text('Results')
                    $.getScript("/js/support-ticket-index.js");

                })
                $("#main").remove();
            }

            function toggleLoader() {
                let loader = `<div class="text-center mt-5">
                                  <div class="spinner-border text-info mx-auto" role="status">
                                      <span class="sr-only">Loading...</span>
                                  </div>
                              </div>`
                $('#title').after(loader)
            }
        })
    </script>--}}
@endpush