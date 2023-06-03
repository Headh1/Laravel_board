@extends('layout.layout')

@section('title','write')
@section('contents')
@include('layout.errors')

    <form action="{{route('boards.write.post')}}" method="post">
    @csrf
        <label for="title">title : </label>
        <input type="text" id="title" name="title">
        <br>
        <label for="content">content : </label>
        <input type="text" id="content" name="content">
        <br>
        <button type="submit">작성</button>
    </form>

@endsection