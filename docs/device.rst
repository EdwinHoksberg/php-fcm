==================
Device Information
==================

There is only 1 device call Firebase exposes, and it can be used to retrieve information about a single device, such as registration date and subscribed topics.

Device Info
===========

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    // Remove the second parameter for more basic device information
    $info = new \Fcm\Device\Info($deviceId, true);

    // Shortcut function:
    // $info = $client->deviceInfo($deviceId, true);

    $client->send($info);

Example response:

.. code-block:: text

    array(10) {
      'applicationVersion' =>
      string(1) "1"
      'connectDate' =>
      string(10) "2018-08-07"
      'attestStatus' =>
      string(6) "ROOTED"
      'application' =>
      string(27) "com.google.application"
      'scope' =>
      string(1) "*"
      'authorizedEntity' =>
      string(12) "347372151029"
      'rel' =>
      array(1) {
        'topics' =>
        array(1) {
          'news' =>
          array(1) {
            'addDate' =>
            string(10) "2018-08-07"
          }
        }
      }
      'connectionType' =>
      string(4) "WIFI"
      'appSigner' =>
      string(40) "c5abd4420a7b4844c034fe9c47fcb42234bbf5fe"
      'platform' =>
      string(7) "ANDROID"
    }
