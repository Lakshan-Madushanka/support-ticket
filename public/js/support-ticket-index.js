$(function () {
    $('#search_btn').on({
        'click': function () {
            loadContent()
        },
        'keypress': function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13) {
                loadContent();
            }
        }
    })

    $('#search').on({
        'keypress': function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13) {
                loadContent();
            }
        }
    })

    function loadContent()
    {
        toggleLoader();

        let value = $('#search').val();
        let currentUrl = window.location.href;

        if (value.trim() === '') {
            $('#search-error').text('Please enter search string')
            return ;
        }

        const params = new URLSearchParams({
            value: value,
        });
        let route = "/support-tickets/search"+'?'+ params;

        if (currentUrl.includes('search-by-id')) {
            route = "/support-tickets/search-by-id"+'?'+ params;
        }

        $('body').load(route+ " #main-wrapper, script", function () {
            $('#search').val(value);
            $('#title').text('Results')
            $.getScript("/js/support-ticket-index.js");
            $.getScript("/js/ticket-reply-modal.js");

        })
        $("#main").remove();
    }

    function toggleLoader() {
        let loader = `<div class="text-center mt-5">
                                  <div class="spinner-border text-info mx-auto" role="status">
                                      <span class="sr-only"></span>
                                  </div>
                              </div>`
        $('#title').after(loader)
    }
})

