@extends(\App\helpers::getLayout())

@section('header')
    @php
         $ticketId = request()->route()->originalParameter('supportTicket');
         $ticketRefId = request()->route()->originalParameter('refId') ?: null ;

         $isIndexRoute = (bool) request()->routeIs('support-ticket-replies.index');
         $isSearchRoute = (bool) request()->routeIs('support-ticket-replies.search');
         $isAdminTicketRepliesRoute = (bool) request()->routeIs('support-ticket.reply.show');
         $isIndexShowRoute = (bool) request()->routeIs('support-ticket.reply.show');

         $type = 'ticketReplies';

             if((bool) request()->routeIs('support-ticket-replies.index'))  {
                 $type = 'replies';
             }
    @endphp

    @if($isIndexRoute)
        {{ucwords("All Replies")}}
    @elseif($isSearchRoute)
        {{ucwords('All replies for the query')}}
        <br/>
        <span class="text-info fs-3 fst-italic">{{$query}}</span>

    @elseif($isAdminTicketRepliesRoute)
        {{ucwords('All replies for the ticket')}}
        <div>
            <a class="lnk-info fs-6 fst-italic"
               href="{{route('support-ticket.show', ['supportTicket' => $ticketId,])}}"
               target="_blank">
                {{$ticketRefId ?? $ticketId}}
            </a>
        </div>
    @else
        {{ucwords('All replies for the ticket')}}
        <div>
            <a class="lnk-info fs-6 fst-italic"
               href="{{route('support-ticket.show', ['supportTicket' => $ticketRefId,])}}"
               target="_blank">
                {{$ticketRefId ?? $ticketId}}
            </a>
        </div>

    @endif
@endsection

@section('main')

    @if($isIndexRoute || $isIndexShowRoute || $isSearchRoute)
        @include('partials.admin.reply-search')
    @endif

    @if ($replies->count() > 0)
        <table class="table table-bordered text-center mb-5">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">id</th>
                <th scope="col">Content</th>
                <th scope="col">Full view</th>

                @if($isIndexRoute || $isAdminTicketRepliesRoute)
                    <th scope="col">Assign</th>
                @endif

                <th scope="col">
                    @if(! $isIndexRoute)
                        Replied_at
                    @else
                        Created_at
                    @endif
                </th>

            </tr>
            </thead>
            <tbody>
            @foreach ($replies as $reply)
                <tr>
                    <th scope="row">{{$loop->iteration	}}</th>
                    <th scope="row">{{$reply->id}}</th>
                    <td>
                        {{$reply->content}}
                    </td>
                    <td>
                        @if($ticketRefId)
                            <a class="lnk-info show-ticket-route"
                               href="{{route('support-ticket-replies.showByRefId', ['replyId' => $reply->id,
                                'referenceId' => $ticketRefId, 'replied_at' => $reply->created_at, 'type' => $type])
                                }}"
                               target="_blank">
                                full view
                            </a>
                        @else
                            <a class="lnk-info show-ticket-route"
                               href="{{route('support-ticket-replies.show', ['reply' => $reply->id,
                                        'replied_at' => $reply->created_at, 'type' => $type])}}"
                               target="_blank">
                                full view
                            </a>
                        @endif
                    </td>
                    @if($isIndexRoute || $isAdminTicketRepliesRoute)
                        <td>assign</td>
                    @endif
                    <td>{{$reply->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="container my-5">
            {{ $replies->onEachSide(5)->links() }}
        </div>
    @endif
@endsection

@push('script')

    <script src="{{asset('js/support-ticket-dashboard.js') }}"></script>
@endpush