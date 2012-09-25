bufferapp-php
=============

Simple PHP class for the amazing buffer at http://bufferapp.com

# Using this class

1. Include the file
	- Make sure you've got `buffer.php` included
2. Create a new BufferApp
	- You'll need to [register an app](http://bufferapp.com/developers/api) with buffer before you can begin
	- Initialize like this `$buffer = new BufferApp($client_id, $client_secret, $callback_url);` The `callback_url` needs to be the exact same as the app you registered
3. Start adding buffers!
	- Once you're in you really only need to check `$buffer->ok` to see if you can perform actions, and then `$buffer->go($endpoint, $data)` to get going!