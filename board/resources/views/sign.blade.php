@extends('layout.layout')

@section('title', 'Sign')

@section('contents')
    @include('layout.valerror')
        <form action="{{route('users.sign.post')}}" method="post">
            @csrf
            <label for="name"> Name : </label>
            <input type="text" name="name" id="name">
            <br>
            <label for="email"> Email : </label>
            <input type="text" name="email" id="email">
            <br>
            <label for="password"> Password : </label>
            <input type="password" name="password" id="password">
            <br>
            <label for="passck"> Password : </label>
            <input type="password" name="passck" id="passck">
            <br>
            <button type="submit">Sign</button>
            <button type="button" onclick="location.href = '{{route('users.login')}}'">cancel</button>
        </form>
@endsection