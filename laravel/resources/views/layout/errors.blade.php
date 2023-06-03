@if($errors->any())
    @foreach($errors->all() as $error)
        <div style="color:salmon">{{$error}}</div>
        
    @endforeach
@endif
