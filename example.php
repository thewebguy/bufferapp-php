<?
	session_start();
	require('buffer.php');
	
	$client_id = '';
	$client_secret = '';
	$callback_url = 'http://127.0.0.1/callback'; //must be set in buffer's app registration settings
	
	//as long as this next line is executed on the $callback_url request you'll be logged in fine
	$buffer = new BufferApp($client_id, $client_secret, $callback_url);
		
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
?>