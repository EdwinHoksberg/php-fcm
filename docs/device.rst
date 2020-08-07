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



Quirks
==================
This plugin uses the underlying package `guzzlehttp` - this package is designed to error out if a URL/Link returns a `404 Not Found`.  However, this can cause the above `DeviceInfo` to error out at as well.  When looking up a deviceID via FCM, if the deviceID does not exist the Google FCM API returns a `404 Not Found` with the JSON value `{"error":"No information found about this instance id."}`.  The 404 causes `guzzlehttp` to throw a Fatal Error and exit the script.  Obviously, this is a major issue if you are scripting mass deviceID lookups - the first not found ID will exit your script.

To get around this, you can use the `http_errors` option, see :doc:`Package Options<packageoptions>`.

Additionally, once the above modification is applied, you will need your processing script to check for JSON key `error` to process the proper error message.  IE:

.. code-block:: php

  $info = new \Fcm\Device\Info($deviceID, true);
  $response =  $client->send($info);
  if (array_key_exists('error',$response)) {
      // process error info here
  } else if (array_key_exists('rel',$response)) {
      // process returned info here
  } else {
      // ID exists but is not registered to any topics/groups/etc
  }

