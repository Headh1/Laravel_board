@extends('layout.layout')

@section('title','login')
@section('contents')
@include('layout.errors')

    <form action="{{route('users.login.post')}}" method="post">
    @csrf
        <label for="email">email : </label>
        <input type="text" id="email" name="email">
        <label for="password">password : </label>
        <input type="password" id="password" name="password">
        <button type="submit">로그인</button>
    </form>

@endsection