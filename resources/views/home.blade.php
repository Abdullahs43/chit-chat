@extends('layouts.app')

@section('content')
<div class="row chat-row">
  
    <div class="col-md-3">
        <div class="users">
            <h5>Users</h5>
            <ul class="list-group list-chat-item">
                @if($users->count())
                  @foreach ($users as $user)
                  <li class="chat-user-list d-flex {{ $loop->first? "active" : ""; }}">
                    <div class="user-image bg-primary text-light">
                        <div class="user-image-name"><center>  {{makeImageFromName($user->name)}} </center></div>
                       
                    </div>
                    <i class="fa-regular fa-circle text-dark status"></i>
                    <a href="" class="user-name">
                        {{$user->name}}
                    </a>
                  </li>
                  @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-md-9  conversation-section">
        <div class="chat-header">
            <li class="chat-user-list d-flex ">
                <div class="user-image bg-primary text-light">
                    <div class="user-image-name"> <center> {{makeImageFromName("Malik Abdullah")}} </center> </div>
                   
                </div>
                <a href="" class="user-name-head">
                    Malik Abdullah
                </a>
                <i class="fa-regular fa-circle text-dark  user-status-head" title="away"></i>
              </li>
        </div>
        <div class="converation-message">
            <div class="chat-header">
                <li class="chat-user-list d-flex ">
                    <div class="user-image bg-primary text-light">
                        <div class="user-image-name"> <center> {{makeImageFromName("Malik Abdullah")}} </center> </div>
                       
                    </div>
                    <a href="" class="user-in-coversation">
                        Malik Abdullah
                    </a>
                    <span class="time text-gray-500" >10:20 PM</span>
                  </li>
            </div>
            <div class="message">
                hellowewe qweqw
            </div>
        </div>
        <div class="input">
            <div id="input-field"></div>
        </div>
       
    </div>
    
  
</div>
@endsection
@section('script')
<script>
    $('#input-field').summernote({ });
  </script>
@endsection