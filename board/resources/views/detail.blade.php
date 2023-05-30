@extends('layout.layout')

@section('title', 'List')

@section('contents')
    <div>
    글번호 : {{$data->id}}
    <br>
    제목 : {{$data->title}}
    <br>
    내용 : {{$data->content}}
    <br>
    등록일: {{$data->created_at}}
    <br>
    수정일 : {{$data->updated_at}}
    <br>
    조회수 : {{$data->hits}}
    <br>
    </div>
    <button type="button" onclick="location.href='{{route('boards.index')}}'">list</button>
    <button type="button" onclick="location.href='{{route('boards.edit',['board' => $data->id])}}'">update</button>
    
    <form action="{{route('boards.destroy',['board' => $data->id])}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="alert('삭제?')">delete</button>
    </form>
@endsection