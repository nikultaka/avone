{{$mailData['subject']}}
{{$mailData['name']}}

Your account create successfully.
<button><a href="{{ route('admin-active-account',[$mailData['id']])}}" style="text-decoration: none; color: inherit;">Active Your Account</a></button> 
<button><a href="{{ route('admin-login')}}" style="text-decoration: none; color: inherit;">Click here for login</a></button>