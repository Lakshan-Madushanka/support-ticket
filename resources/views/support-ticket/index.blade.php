@extends('layouts.dashboard')

@section('header')
    {{ucwords("All Tickets")}}
@endsection

@section('main')
    @if ($tickets->isEmpty())
        <div class="alert alert-info text-info text-center">
            <h3>No Tickets Found</h3>
        </div>
    @endif

    @include('partials.ticket-search')
    @includeWhen($tickets->isNotEmpty(), 'partials.admin.ticket-filters')

    @if ($tickets->isNotEmpty())
        <div class="table table-bordered table-responsive">
            <table class="table table-bordered table-striped table-responsive text-center mb-5">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Id</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Ref Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Replies</th>
                    <th scope="col">Full view</th>
                    <th scope="col">Reply</th>
                    <th scope="col">Created</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <th scope="row">{{$loop->iteration	}}</th>
                        <th scope="row">{{$ticket->id}}</th>
                        <th scope="row">

                            <span class="{{\App\Services\SupportTicket\SupportTicketService::priorityCssClass($ticket->priority)}}">
                                {{\App\Services\SupportTicket\SupportTicketService::priorityTextFromCode($ticket->priority)}}
                            </span>
                        </th>
                        <td scope="row">{{$ticket->reference_id}}</td>
                        <td scope="row">{{$ticket->name}}</td>
                        <td scope="row">{{$ticket->email}}</td>
                        <td scope="row">{{$ticket->phone_number}}</td>
                        <td scope="row">
                            {{$ticket->description}}
                        </td>

                        <span class="p-4 text-gray-500 bg-red"></span>
                        <td scope="row">
                            @if($ticket->is_pending)
                                <span class="badge rounded-pill bg-danger"> {{$ticket->status_text}}</span>
                            @elseif($ticket->is_viewed)
                                <span class="badge rounded-pill bg-warning"> {{$ticket->status_text}}</span>
                            @else
                                <span class="badge rounded-pill bg-info"> {{$ticket->status_text}}</span>
                            @endif
                        </td>
                        <td scope="row">
                            @if ($ticket->replies_count === 0)
                                0
                            @elseif (! request()->routeIs('support-ticket.searchByRefId'))
                                <a href="{{route('support-ticket.reply.show', ['supportTicket' => $ticket->id])}}"
                                target="_blank">
                                    {{$ticket->replies_count}}
                                </a>
                            @else
                                <a href="{{route('support-ticket.reply.searchByRefId',[
                                                'supportTicket' => $ticket->id,
                                                'refId' => $ticket->reference_id
                                       ])}}" target="_blank">
                                    {{$ticket->replies_count}}
                                </a>
                            @endif
                        </td>
                        <td scope="row">
                            <a href="{{route('support-ticket.show', ['supportTicket' => $ticket->id])}}"
                               class="link-primary" target="_blank">full view</a></td>
                        <td scope="row">
                            @if($ticket->reply_status === 'reply')
                                <a key={{$ticket->id}} href="#!"
                                   class="link-primary ticket-reply-link">{{$ticket->reply_status}}
                                </a>
                            @else
                                {{$ticket->reply_status}}
                            @endif
                        </td>
                        <td>{{$ticket->created_at->toDayDateTimeString()}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="container mb-5">
                {{ $tickets->onEachSide(5)->links() }}
            </div>
        </div>

        @includeWhen(! $tickets->isEmpty(), 'partials.ticket-reply-modal')


        <!-- Modal -->
{{--        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--            <div class="modal-dialog">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="exampleModalLabel">Replty to support ticket</h5>--}}
{{--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        Please select below option--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-primary" id="model-reply-button">--}}
{{--                            <a href="{{route('support-ticket.reply.create', ['id' => $ticket->id])}}"--}}
{{--                               class="link-primary reply-link text-white text-decoration-none">--}}
{{--                                New Reply--}}
{{--                            </a>--}}
{{--                        </button>--}}
{{--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                        <button type="button" class="btn btn-primary" id="model-assign-button">--}}
{{--                            <a href="{{route('support-ticket.reply.assign.create', ['id' => $ticket->id])}}"--}}
{{--                               class="link-primary reply-link text-white text-decoration-none">--}}
{{--                                Assign Reply--}}
{{--                            </a>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    @endif

@endsection

@push('script')
    <script src="{{asset('js/support-ticket-dashboard.js') }}"></script>
@endpush

{{--@push('script')--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            var myModal = new bootstrap.Modal(document.getElementById('myModal'))--}}

{{--            $(".ticket-reply-link").click(function () {--}}
{{--                const primaryKey = $(this).attr('key');--}}
{{--                let newReplyRoute = '{{route('support-ticket.reply.create', ['id' => ':id'])}}';--}}
{{--                let assignReplyRoute = "{{route('support-ticket.reply.assign.create', ['id' => ':id'])}}";--}}

{{--                newReplyRoute = newReplyRoute.replace(':id', primaryKey)--}}
{{--                assignReplyRoute = newReplyRoute.replace(':id', primaryKey)--}}

{{--                $('#model-reply-button a').attr('href', newReplyRoute)--}}
{{--                $('#model-assign-button a').attr('href', assignReplyRoute)--}}

{{--                myModal.show();--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}
{{--@endpush--}}

