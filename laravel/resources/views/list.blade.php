@extends('layout.layout')
@section('title','list')
@section('contents')
<h1>🍸 과일 쥬스 🍹</h1>

<table>
    <tr>
        <th>글번호</th>
        <th>제목</th>
        <th>내용</th>
    </tr>
    @forelse($list as $val)        
    <tr>
        <td>{{$val->id}}</td>
        <td>{{$val->title}}</td>
        <td>{{$val->content}}</td>
    </tr>
    @empty
        <p>자료없음</p>
    @endforelse
</table>
<a href="{{route('boards.write')}}">작성</a>
@endsection