@extends('layout.layout')

@section('title', 'myinfo')

@section('contents')
@include('layout.valerror')
<main>
<form action="{{route('users.myinfo.put')}}" method="post">
    @csrf
    @method('PUT')
    <label for="name"> Name : </label>
    <input type="text" name="name" id="name" value="{{$data->name}}" >
    <br>
    <label for="email"> Email : </label>
    <input type="text" name="email" id="email" value="{{$data->email}}">
    <br>
    <label for="nowPw"> NOW Password : </label>
    <input type="password" name="nowPw" id="nowPw">
    <br>
    <label for="password"> NEW Password : </label>
    <input type="password" name="password" id="password" >
    <br>
    <label for="passck"> Password CK: </label>
    <input type="password" name="passck" id="passck">
    <br>
    <br>
    <button type="submit">수정하기</button>
    <button type="button" onclick="location.href = '{{route('users.withraw')}}'">탈퇴하기</button>
</form>
</main>
@endsection