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
                    <i class="fa-solid fa-circle text-dark status user-icon-{{$user->id}}" title="away"></i>
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
                <i class="fa-solid fa-circle text-dark user-status-head" title="away"></i>
              </li>
        </div>
        <hr>
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
            <textarea name="message" id="input_field"></textarea>
        </div>
       
    </div>
</div>
@endsection
@push('scripts')

<script>
    $('#input_field').summernote({ });
        $(function (){
            let chatInput = $('.note-editable');
            let user_id = "{{ auth()->user()->id }}";
            let ip_address = '127.0.0.1';
            let socket_port = '8001';
            let socket = io(ip_address + ':' + socket_port);
            let friendId = 10;

            socket.on('connect', function() {
               socket.emit('user_connected', user_id);
            });
            
            socket.on('updateUserStatus', (data) => {
                $.each(data, function (key, val) {
                
                   if (val !== null && val !== 0) {
                      let $userIcon = $(".user-icon-"+key);
                      $userIcon.removeClass('text-dark');
                      $userIcon.addClass('text-success');
                      $userIcon.attr('title','Online');
                   }
                });
            });


            chatInput.keypress(function (e) {
               let message = $(this).html();
               console.log(e.which);
               if (e.which === 113 && !e.shiftKey) {
                   chatInput.html("");
                   sendMessage(message);
                   return false;
               }
            });
            function sendMessage(message) {
                let url = "{{ route('message.send-message') }}";
                let form = $(this);
                let formData = new FormData();
                let token = "{{ csrf_token() }}";
                formData.append('message', message);
                formData.append('_token', token);
                formData.append('receiver_id', friendId);
              
           
                $.ajax({
                   url: url,
                   type: 'POST',
                   data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                   success: function (response) {
                       if (response.success) {
                           console.log(response.data);
                       }
                   }
                });
            }
        
        });
    </script>
@endpush