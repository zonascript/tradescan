<h2>Welcome to Zaber</h2>
<p>Your login is: {{ $data['email'] }}</p>
<p>Your password is: {{ $data['password'] }}</p>

Please follow the link to get access.

<a href="{{ route('confirmation', $data['token']) }}">{{ route('confirmation', $data['token']) }}</a>



