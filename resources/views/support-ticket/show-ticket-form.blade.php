
@extends(\App\helpers::getLayout())

@section('header')
   {{ucwords("Ticket Info")}}
@endsection

@section('main')
    <form class="w-50 mx-auto" method="get" action="{{route('support-ticket.reply.create', ['id' => $ticket->id])}}">
        <div class="form-group mb-4">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name"
                   placeholder="Enter name" value="{{$ticket->name}}" name="name" required readonly>
        </div>

        <div class="form-group mb-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email"
                   placeholder="Enter email" name="email" required value="{{$ticket->email}}" readonly>
        </div>

        <div class="form-group mb-4">
            <label for="phone_number">Phone Number</label>
            <input type="number" class="form-control" id="phone_number" aria-describedby="phone number"
                   placeholder="Enter phone number" name="phone_number" required value="{{$ticket->phone_number}}" readonly>
        </div>

        <div class="form-group mb-4">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description"
                      required minlength="5" readonly
            >
                {{$ticket->description}}
            </textarea>
        </div>

        <div class="form-group mb-4">
            <label for="status">Status</label>
            <input type="status" class="form-control" id="status" aria-describedby="status"
                   placeholder="Enter status" name="status" required
                   value="{{$ticket->status_text}}" readonly>
        </div>

        @can('supportAgent')
            <div class="form-group mb-4">
                <button type="submit" class="btn btn-primary">Reply</button>
            </div>
        @endcan
    </form>
@endsection