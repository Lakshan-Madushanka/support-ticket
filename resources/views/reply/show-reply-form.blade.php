
@extends(\App\helpers::getLayout())

@section('header')
    {{ucwords("Reply Status")}}
@endsection

@section('main')
    <form class="w-50 mx-auto" method="get" action="">
        <div class="form-group mb-4">
            <label for="content">Content</label>
            <input type="text" class="form-control" id="content" aria-describedby="content"
                   placeholder="Enter content" value="{{$reply->content}}" name="content" required disabled>
        </div>

        <div class="form-group mb-4">
            <label for="created_at">Created at</label>
            <input type="text" class="form-control" id="created_at" aria-describedby="created_at"
                   placeholder="Enter created_at" name="created_at" required value="{{$reply->created_at}}" disabled>
        </div>

        @if($reply->replied_at)
            <div class="form-group mb-4">
                <label for="created_at">Replied at</label>
                <input type="text" class="form-control" id="created_at" aria-describedby="created_at"
                       placeholder="Enter created_at" name="created_at" required value="{{$reply->replied_at}}" disabled>
            </div>
        @endif

    </form>
@endsection