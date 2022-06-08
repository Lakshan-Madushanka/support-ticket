@extends(\App\helpers::getLayout())

@push('css')
    <style>
        .results {
            letter-spacing: 15px;
        }
    </style>

@endpush

@section('header')
    {{ucwords("Search Tickets")}}
@endsection

@section('main')
    <div class="alert alert-danger text-info text-center d-none">
        <h3>alert</h3>
    </div>

    <div class="container">
        <div class="mx-auto w-75">
            <div class="form-group mb-2">
                <input type="text" class="form-control" id="search" aria-describedby="name"
                       placeholder="Search" value="" name="search" required>
            </div>
            <div class="text-center text-danger mb-2 mt-1" id="search-error"></div>

            <div class="d-grid gap-2 w-50 mx-auto mb-4">
                <button id="search_btn" class="btn btn-primary" type="button">Search</button>
                <div class="spinner-border text-info mx-auto d-none mt-5" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="text-info  d-none results mb-3">
        <h3 class="results">Results :</h3>
    </div>

    <div class="table table-bordered table-responsive d-none" id="table-wrapper">
        <table class="table table-bordered table-responsive text-center mb-5">
            <thead>
            <tr>
                {{--                <th scope="col">No</th>--}}
                <th scope="col">Ref Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Replies</th>
                <th scope="col">Full view</th>
                <th scope="col">Created</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@push('script')
    <script>
        $(function () {
            console.log('hello')

            $(document)
                .ajaxStart(function () {
                    enaleLoader()
                    clearAlert()
                    clearSearchErrorText()
                    disableSearchBtn()
                    disableResultsElm()
                    disableTable()
                })
                .ajaxStop(function () {
                    disableLoader()
                    enableSearchBtn()
                });

            let searchInputElm = $("input[name='search']");

            (function loadTicketsOnQueryParam() {
                const urlParams = new URLSearchParams(window.location.search);
                const refId = urlParams.get('value');

                searchInputElm.val(refId)

                if (refId && refId.trim() !== '') {
                    loadTickets(refId);
                }
            })()

            $("#search_btn").on('click', function () {
                loadTickets(searchInputElm.val());
            })

            searchInputElm.on('keypress', function (e) {
                if (e.which == 13) {
                    loadTickets(searchInputElm.val());
                }
            })


            function loadTickets(refId) {
                const val = refId

                if (val.trim() === '') {
                    setSearchErrorText();
                    return
                }

                const route = "{{route('api.support-tickets.searchByRefId')}}/?" + "value=" + val;

                $.get(route, function (data, status, error) {
                    // var err = JSON.parse(data);
                    enableTable()
                    setTableRow(data)
                    enableResultsElm()
                    $('.results').removeClass('d-none').addClass('d-block')
                }).fail(function (data) {
                    if (data.status == 422) {
                        var err = JSON.parse(data.responseText);
                        if (err.message && err.message.includes('invalid')) {
                            setAlert("Invalid Reference Id")
                            return
                        }
                        setSearchErrorText()
                    }

                })
            }

            function enableResultsElm() {
                $('.results').removeClass('d-none').addClass('d-block')
            }

            function disableResultsElm() {
                $('.results').removeClass('d-block').addClass('d-none')
            }

            function enableTable() {
                $('#table-wrapper').removeClass('d-none').addClass('d-block')
            }

            function disableTable() {
                $('#table-wrapper').removeClass('d-block').addClass('d-none')
            }

            function setSearchErrorText() {
                $('#search-error').text("Please enter reference id value")
            }

            function clearSearchErrorText() {
                $('#search-error').text("")
            }

            function enaleLoader() {
                $(".spinner-border").removeClass('d-none').addClass('d-block')
            }

            function disableLoader() {
                $(".spinner-border").removeClass('d-block').addClass('d-none')
            }

            function disableSearchBtn() {
                $("#search_btn").removeClass('d-block').addClass('d-none')
            }

            function enableSearchBtn() {
                $("#search_btn").removeClass('d-none').addClass('d-block')
            }

            function setAlert(text) {
                $('.alert').removeClass('d-none').addClass('d-block')
                $(".alert h3").text(text)
            }

            function clearAlert(text) {
                $('.alert').removeClass('d-block').addClass('d-none')
            }

            function setTableRow(ticket) {
                content =
                    `<tr>
                        <td>${ticket['reference_id']}</td>
                        <td>${ticket['name']}</td>
                        <td>${ticket['email']}</td>
                        <td>${ticket['phone_number']}</td>
                        <td id='description'>${ticket['description']}</td>
                         <td> <span class="badge rounded-pill bg-info"> ${ticket['status']}</span></td>
                        <td id='reply'>  </td>
                        <td id='full-view'>  </td>
                        <td>${ticket['created_at']}</td>
                        </tr>`

                $('tbody').html(content);

                setRepliesCount(ticket);
                setfullView(ticket)
                // setDescription(ticket['description'])
            }

            function setRepliesCount(ticket) {
                if (ticket['replies_count'] === 0) {
                    $('#reply').text(0)
                } else {
                    let route = "{{
                                    route('support-ticket.reply.searchByRefId', [
                                                    'supportTicket' => ":ticketId",
                                                    'refId' => ':refId'
                                           ])
                                }}"
                    let elm = `<a href="" target="_blank">
                                    ${ticket['replies_count']}
                               </a>`

                    route = route.replace(':ticketId', ticket['id']);
                    route = route.replace(':refId', ticket['reference_id']);

                    $('#reply').html(elm)
                    $('#reply a').attr('href', route)
                }
            }

            function setfullView(ticket) {
                let route = "{{route('support-ticket.show', ['supportTicket' => ':ticketId'])}}"
                route = route.replace(':ticketId', ticket['reference_id']);

                let elm = `<td>
                        <a href="${route}" target="_blank"
                           class="link-primary">full view</a></td>
                        <td> `

                $('#full-view').html(elm)
            }

            function setDescription(description) {
                if (description.length > 10) {
                    description = description.slice(0, 10) + '...';
                }

                $('#description').text(description)
            }
        })
    </script>
@endpush