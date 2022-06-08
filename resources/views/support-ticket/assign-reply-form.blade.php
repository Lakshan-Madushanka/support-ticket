@extends('layouts.dashboard')

@section('header')
{{ucwords("Assign reply")}}
@endsection

@section('main')
    @if($errors->any())
    <div class="alert alert-danger text-center"> One or more Validation errors occurred !</div>
    @endif
    <form class="w-50 mx-auto" method="post" action="{{route('support-ticket.reply.assign', ['supportTicket' => $id])}}">
        @csrf
        <div class="form-group mb-4">
            <label class="mb-2" for="reply">Select reply id</label>
            <select class="form-control select-box" id="reply" name="replyId">
                @foreach($replyIds as $id)
                    <option value="{{$id}}">{{$id}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-4 content-wrapper d-none">
            <label class="mb-2" for="content">Content</label>
            <textarea class="form-control" id="content" rows="3" name="content"
                      required minlength="5" disabled
            >
            </textarea>
        </div>
        <div class="spinner-border text-info d-none" role="status">
            <span class="sr-only"></span>
        </div>

        <div class="form-group mb-4">
            <label for="ticket_status">Ticket Status</label>
            <select class="form-control mt-2" id="ticket_status" name="status">
                @foreach(\App\Services\SupportTicket\SupportTicketReplyService::availableReplyStatus() as $code)
                    <option value="{{ $code}}")>
                        {{\App\Services\SupportTicket\SupportTicketService::statusTextfromCode($code)}}
                    </option>
                @endforeach
            </select>
        </div>
        @error('status')
        <div class="text-center text-danger">{{$message}}</div>
        @enderror

        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary assign-btn disabled">Assign Selected Reply</button>
        </div>

    </form>
@endsection

@push('script')
    <script>
        $(function () {

            let replyId;

            $('.select-box').change(function () {
                loadReplyContent(this)
            })

            function loadReplyContent(vm) {
                $('.spinner-border').removeClass('d-none')

                $('.btn').addClass('d-none')

                console.log('changed',  $('meta[name="csrf-token"]').attr('content'))
                const selectedId = $(vm).val()
                const route = "{{route('api.support-ticket-reply.show', '')}}/" + selectedId
                console.log(route)
                $.get(route, function (data) {
                    console.log(data)
                    $('.spinner-border').addClass('d-none')

                    $('.content-wrapper').removeClass('d-none').addClass('d-block')

                    $('.btn').removeClass('d-none').addClass('d-block').removeClass('disabled')

                    $('#content').text(data.content)
                    replyId = selectedId;
                })
            }
            loadReplyContent($('.select-box'))


            /*  $('.assign-btn').click(function () {
                  if (! replyId) return;

{{--const route = "{{route('api.support-ticket-reply.store', ['supportTicket' => 10])}}"--}}

                $.ajax({
                    type:'POST',
                    url:route,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {replyId: replyId, _token: {{csrf_token()}} },
                    success:function(data){
                       console.log(data)
                    }
                });

            })*/
        })
    </script>
@endpush