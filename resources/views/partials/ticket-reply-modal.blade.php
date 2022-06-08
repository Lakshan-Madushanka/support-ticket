<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reply to support ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Please select below option
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="model-reply-button">
                    <a href="{{route('support-ticket.reply.create', ['id' => $ticket->id])}}"
                       class="link-primary reply-link reply-button text-white text-decoration-none" target="_blank">
                        New Reply
                    </a>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="model-assign-button">
                    <a href="{{route('support-ticket.reply.assign.create', ['supportTicket' => $ticket->id])}}"
                       class="link-primary reply-link reply-button text-white text-decoration-none" target="_blank">
                        Assign Reply
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>

@push('script')
{{--    <script src="{{asset('js/ticket-reply-modal.js') }}"></script>--}}

    {{--<script>
        $(function () {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'))

            $(".ticket-reply-link").click(function () {
                const primaryKey = $(this).attr('key');
                let newReplyRoute = '{{route('support-ticket.reply.create', ['id' => ':id'])}}';
                let assignReplyRoute = "{{route('support-ticket.reply.assign.create', ['id' => ':id'])}}";

                newReplyRoute = newReplyRoute.replace(':id', primaryKey)
                assignReplyRoute = assignReplyRoute.replace(':id', primaryKey)

                $('#model-reply-button a').attr('href', newReplyRoute)
                $('#model-assign-button a').attr('href', assignReplyRoute)

                myModal.show();
            })
        })
    </script>--}}
@endpush