bufferapp-php
=============

Simple PHP library for the amazing buffer at http://bufferapp.com

# Why?

There wasn't one listed on buffer's website and a quick Google search didn't come up. For most use cases buffer's plugins will work just fine, but for those of you looking to pump lots of info into buffer via PHP this may help!

# Using this library

1. Include the file
	- Make sure you've got `buffer.php` included
2. Create a new BufferApp
	- You'll need to [register an app](http://bufferapp.com/developers/api) with buffer before you can begin
	- Initialize like this `$buffer = new BufferApp($client_id, $client_secret, $callback_url);` The `callback_url` needs to be the exact same as the app you registered
3. Start adding buffers!
	- Once you're in you really only need to check `$buffer->ok` to see if you can perform actions, and then `$buffer->go($endpoint, $data)` to get going!
		
# Example

First thing's first: start a session and require `buffer.php`. We're going to be storing the `access_token` in the session for now.

		session_start();
		require('buffer.php');

Set this thing up with your credentials and your callback URL. Remember: `callback_url` must match what you've got in buffer exactly!

		$client_id = '';
		$client_secret = '';
		$callback_url = 'http://127.0.0.1/callback';

Set up the new buffer client. This is a super simple action that does a few things under the hood.
If `$_GET['code']` is set on this page it assumes it came from buffer and will attempt to trade that code for an `access_token`. If there is an `access_token` in the session it will be loaded in.

		$buffer = new BufferApp($client_id, $client_secret, $callback_url);

Once we've got an `access_token` set the `$buffer->ok` property will read true. It is false by default. 
Now that we've received access we are free to run queries against buffer endpoints! Below we pull the list of profiles associated with the logged in buffer user and submit a test update to each one.

		if (!$buffer->ok) {
			echo '<a href="' . $buffer->get_login_url() . '">Connect to Buffer!</a>';
		} else {
			//this pulls all of the logged in user's profiles
			$profiles = $buffer->go('/profiles');
			
			if (is_array($profiles)) {
				foreach ($profiles as $profile) {
					//this creates a status on each one
					$buffer->go('/updates/create', array('text' => 'My first status update from bufferapp-php worked!', 'profile_ids[]' => $profile->id));
				}
			}
		}

# Storage

Right now this baby just stores the `access_token` in `$_SESSION['oauth']['buffer']['access_token']`. If you are doing something serious with this you should probably rewrite the `store_access_token()` and `retrieve_access_token()` methods.

I'm going to be using this in a real world project startin this week, so hopefully I'll have some major updates for it. Any help is appreciated!