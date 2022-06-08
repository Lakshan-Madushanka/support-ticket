$(function () {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'))

    $(".ticket-reply-link").click(function () {
        const primaryKey = $(this).attr('key');
        let newReplyRoute = `support-tickets/${primaryKey}/reply/create`;
        let assignReplyRoute = `support-tickets/${primaryKey}/assign-reply/create`;;

        newReplyRoute = newReplyRoute.replace(':id', primaryKey)
        assignReplyRoute = assignReplyRoute.replace(':id', primaryKey)

        $('#model-reply-button a').attr('href', newReplyRoute)
        $('#model-assign-button a').attr('href', assignReplyRoute)

        myModal.show();
    })

    $(".reply-button").on('click', function () {
        console.log('hello')
        myModal.hide();
    })
})