<h1><a href="{{route('boards.index')}}">BOARD</a></h1>

{{-- 로그인 중 --}}
@auth
    <div><a href="{{route('users.logout')}}">로그아웃</a></div>
    <div><a href="{{route('users.myinfo')}}">내 정보</a></div>
@endauth

{{-- 로그인 하기 전 --}}
@guest
    <div><a href="{{route('users.login')}}">로그인</a></div>
@endguest