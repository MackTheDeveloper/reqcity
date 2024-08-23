@if ($accountManagers)
    @foreach ($accountManagers as $key=>$item)
        <option {{in_array($key,$accountManagerSelected)?"selected":""}} value="{{$key}}">{{$item}}</option>
    @endforeach
@endif