@extends('layout.layout')

@section('title', 'List')

@section('contents')
    {{-- @if(count($errors)>0)
        @foreach($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    @endif --}}
    @include('layout.valerror')
    <main>
    <form action="{{route('boards.store')}}" method="post">
    @csrf
    <label for="title">제목 : </label>
    <input type="text" name="title" id="title" value="{{old('title')}}">
    <br>
    <label for="content">내용 : </label>
    <textarea name="content" id="content" >{{old('content')}}</textarea>
    <button type="submit">작성하기</button>
    </form>
    </main>
@endsection