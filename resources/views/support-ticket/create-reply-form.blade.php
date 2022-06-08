@extends('layouts.dashboard')

@section('header')
    {{ucwords("reply ticket")}}
@endsection

@section('main')
    @if($errors->any())
    <div class="alert alert-danger text-center"> One or more Validation errors occurred !</div>
    @endif

    <form class="w-50 mx-auto" method="post" action="{{route('support-ticket.reply.store', ['supportTicket' => $id])}}">
        @csrf
        <div class="form-group mb-4">
            <label for="reply">Content</label>
            <textarea class="form-control"  placeholder="Reply goes here..."
                      rows="10" cols="50" id="reply" name="reply" required minlength="5">
                                {{old('reply')}}
            </textarea>
        </div>
        @error('reply')
        <div class="text-center text-danger">{{$message}}</div>
        @enderror

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
            <button type="submit" class="btn btn-primary">Reply</button>

        </div>
    </form>
@endsection