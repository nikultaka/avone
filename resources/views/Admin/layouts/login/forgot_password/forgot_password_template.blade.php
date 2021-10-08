<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome!</div>
                  <div class="card-body">
                    <h1> Hii user<br> </h1>
                    {{-- name : {{ $userdata["name"] }} <br> --}}
                    email : {{ $userdata["email"] }} <br>
                       <h3>  
                                <a href="{{ route('admin-new-password-view',[$userdata['token']]) }}">Click me for set new password</a> 
                            </p>
                     </h3> 
               </div>
           </div>
       </div>
   </div>
</div> 

