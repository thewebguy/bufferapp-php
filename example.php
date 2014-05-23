<?php

  require 'vendor/autoload.php';

  use Buffer\App\BufferApp;

  session_start();

  $client_id = '';
  $client_secret = '';
  $callback_url = 'http://127.0.0.1/callback';

  $buffer = new BufferApp($client_id, $client_secret, $callback_url);

  if (!$buffer->ok) {
    echo '<a href="' . $buffer->get_login_url() . '">Connect to Buffer!</a>';
  } else {
    $profiles = $buffer->go('/profiles');

    if (is_array($profiles)) {
      foreach ($profiles as $profile) {
        $buffer->go('/updates/create', array(
          'text' => 'My first status update from BufferApp worked!',
          'profile_ids[]' => $profile->id));
      }
    }
  }