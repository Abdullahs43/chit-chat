@extends('layouts.app')

@section('content')
<div class="row chat-row">
  
    <div class="col-md-3">
        <div class="users">
            <h5>Users</h5>
            <ul class="list-group list-chat-item">
                @if($users->count())
                  @foreach ($users as $user)
                  <li class="chat-user-list d-flex">
                    <div class="user-image bg-primary text-light">
                        <div class="user-image-name"><center>  {{makeImageFromName($user->name)}} </center></div>
                    </div>
                    <a href="" class="user-name">
                        {{$user->name}}
                    </a>
                  </li>
                  @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
