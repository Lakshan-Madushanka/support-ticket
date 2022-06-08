@extends('layouts.main')

@section('header')
    {{ucwords("Create ticket")}}
@endsection

@section('main')
    <form class="w-50 mx-auto" method="post" action="{{route('support-ticket.store')}}">
        @csrf
        <div class="form-group mb-4">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name"
                   placeholder="Enter name" value="{{old('name')}}" name="name" required>
        </div>
        @error('name')
        <div class="text-center text-danger">{{$message}}</div>
        @enderror
        <div class="form-group mb-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="email"
                   placeholder="Enter email" name="email" required value="{{old('email')}}">
        </div>
        @error('email')
        <div class="text-center text-danger">{{$message}}</div>
        @enderror
        <div class="form-group mb-4">
            <label for="phone_number">Phone Number</label>
            <input type="number" class="form-control" id="phone_number" aria-describedby="phone number"
                   placeholder="Enter phone number" name="phone_number" required value="{{old('phone_number')}}">
        </div>
        @error('phone_number')
        <div class="text-center text-danger">{{$message}}</div>
        @enderror
        <div class="form-group mb-4">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" rows="3" name="description"
                      required minlength="5"
            >
                {{old('description')}}
            </textarea>
        </div>
        @error('description')
        <div class="text-center text-danger">{{$message}}</div>
        @enderror
        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary">Create Ticket</button>
        </div>
    </form>
@endsection