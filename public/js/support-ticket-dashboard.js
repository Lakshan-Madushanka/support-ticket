
//support ticket and support ticket reply search functionality
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
        let value = $('#search').val();
        let currentUrl = window.location.href;

        console.log(currentUrl)
        if (! value || value.trim() === '') {
            $('#search-error').text('Please enter search string')
            return;
        }
        addLoader();

        const params = new URLSearchParams({
            value: value,
        });
        let route = "https://supportticket.io/support-tickets/search" + '?' + params;

        if (currentUrl.includes('search-by-id')) {
            route = "/support-tickets/search-by-id" + '?' + params;
        }else if(currentUrl.includes('replies')) {
            route = 'https://supportticket.io/support-ticket-replies/search?' + params;
           // route = 'support-ticket-replies/search' + '?' + params
        }

        $('body').load(route + "#main-wrapper", function () {
            $('#search').val(value);
            $('#title').text('Results')
            //$.getScript("/js/support-ticket-dashboard.js");

        })
        $("#main").remove();
    }

    function addLoader() {
        let loader = `<div class="text-center mt-5 loader">
                                  <div class="spinner-border text-info mx-auto" role="status">
                                      <span class="sr-only"></span>
                                  </div>
                              </div>`
        $('#title').after(loader)
    }

    function removeLoader() {
        $('.loader').remove();
    }

    // setup model
    (() => {
            const modal = $('#myModal');

            if (!modal.length) {
                return;
            }
            var myModal = new bootstrap.Modal(modal)


            $(".ticket-reply-link").click(function () {
                const primaryKey = $(this).attr('key');
                let newReplyRoute = `support-tickets/${primaryKey}/reply/create`;
                let assignReplyRoute = `support-tickets/${primaryKey}/assign-reply/create`;

                newReplyRoute = newReplyRoute.replace(':id', primaryKey)
                assignReplyRoute = assignReplyRoute.replace(':id', primaryKey)

                $('#model-reply-button a').attr('href', newReplyRoute)
                $('#model-assign-button a').attr('href', assignReplyRoute)

                myModal.show();
            })

            $(".reply-button").on('click', function () {
                myModal.hide();
            });
        }
    )();

    // filters functionality

    let statusSelectorElm = $('.admin-filters-wrapper .status-select');
    let dateFilterElm = $('.admin-filters-wrapper .date-check-input');

    statusSelectorElm.on('change', function () {
        loadPageOnFilters();
    })

    dateFilterElm.on('change', function () {
        let dateFilterElm = $('.admin-filters-wrapper .date-check-input[name=dateOrder]:checked');
        loadPageOnFilters();
    })

    function loadPageOnFilters() {
        addLoader();

        let dateFilterElm = $('.admin-filters-wrapper .date-check-input[name=dateOrder]:checked');
        let statusSelectorElm = $('.admin-filters-wrapper .status-select option:selected');

        selectedStatus = statusSelectorElm.val();
        selectedDateOrder = dateFilterElm.val();

        route = '/support-tickets';

        const params = new URLSearchParams({
            'status': selectedStatus,
            'orderByDate': selectedDateOrder
        })

        route = route + '?' + params.toString();

        $('body').load(route, '#main-wrapper', function () {
            //$.getScript("/js/support-ticket-dashboard.js");
            setFilterStatus(selectedStatus, selectedDateOrder);
        })
    }

    function setFilterStatus(status, dateOrder) {
        selectedStatusOptionElm = $(`.admin-filters-wrapper .status-select option[value=${status}]`)
        selectedDateOrderElm = $(`.admin-filters-wrapper .date-check-input[value=${dateOrder}]`)
        selectedStatusOptionElm.attr('selected', 'true');
        selectedDateOrderElm.attr('checked', true);
    }

})

