================
Sending Messages
================

There are two different types of messages Firebase can support, `Notification messages` and `Data messages`.
Read `here <https://firebase.google.com/docs/cloud-messaging/concept-options>`_ for more information.

Notification message to deviceIDs <to> <registration_ids> <deviceGroupID>
====================

`FCM automatically displays the message to end-user devices on behalf of the client app. Notification messages have a predefined set of user-visible keys and an optional data payload of custom key-value pairs.`

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $notification = new \Fcm\Push\Notification();
    $notification
        ->addRecipient($deviceId1)
        ->addRecipient($deviceGroupID)
        ->addRecipient($arrayIDs)
        ->setTitle('Hello from php-fcm!')
        ->setColor('#20F037')
        ->setSound("default")
        ->setBadge(11);

    // Shortcut function:
    // $notification = $client->pushNotification('The title', 'The body', $deviceId);

    $response = $client->send($notification);

Example deviceID <to> <registration_ids> <deviceGroupID> response:

.. code-block:: text

    array(5) {
      'multicast_id' =>
      int(9014353506250345342)
      'success' =>  
      int(1)   // how many deviceIDs were successfully sent messages
      'failure' =>
      int(1)   // how many deviceIDs messages failed to send to
      'canonical_ids' =>
      int(0)
      'results' =>
      array(2) {
        [0] =>  // each deviceID message success or failure
        array(1) {
          'message_id' =>  //first ID success
          string(35) "0:154231004164960%c5f39c08c5f39c543"
        }
        [1] =>  // each deviceID message success or failure
        array(1) {
          'error' =>  // second ID failure
          string(19) "InvalidRegistration"
        }
      }
    }

Notification message <topics>
====================

`FCM automatically displays the message to end-user devices on behalf of the client app. Notification messages have a predefined set of user-visible keys and an optional data payload of custom key-value pairs.`

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $notification = new \Fcm\Push\Notification();
    $notification
        ->addRecipient('/topics/myTopicName')
        ->setTitle('Hello myTopicName Members')
        ->setColor('#20F037')
        ->setSound("default")
        ->setIcon("myIcon.png");

    // Shortcut function:
    // $notification = $client->pushNotification('The title', 'The body', $deviceId);

    $response = $client->send($notification);

Example <topics> response:

.. code-block:: text

    array(1) {
        'message_id' =>  // this is a successful response to a topic notification
        int(154231004164960%c5f39c08c5f39c543)
      }
  
    array(1) {
        'error' =>  // this is an error response to a topic notification
        string(19) "InvalidRegistration"
      }


Notification sending options
====================

.. code-block:: text

     * addRecipient 
          // recipient can be ONE of four types
          // deviceID (string)
          // devicegroupID (string)
          // registeredIDs (array_of_IDs)
          // topicID ('/topics/myTopicID')
          
          // note: deviceID/deviceGroupID/registerIDs can be mixed/matched in same notification
          // note: topicID can not be mixed/matched with other IDs types in same notification

Notification options <topics> <deviceID> <registered_ids>
====================
`iOS, Android currently Supported options for notifications`

.. code-block:: text

     iOS only:
     * setBbadge (int)
     * setSubtitle (string)

     Android only:
     * setTag (string)
     * setColor (string (hex #rrggbb color format))
     * setIcon (string)
         // custom icon file must be in app itself
         // icon must be drawable resource, if not set, FCM displays launcher icon in app manifest
         // for more info, see: https://github.com/arnesson/cordova-plugin-firebase/issues/764
     *** future: android_channel_id

     Both:
     * setTitle (string)
     * setBody (string)
     * setSound (string)
         // custom sound must be in the app itself
         // custom sound file must be in /res/raw/
     *** future: click_action
     *** future: body_loc_key
     *** future: body_loc_args
     *** future: title_loc_key
     *** future: title_loc_args

Data message
============

`Client app is responsible for processing data messages. Data messages have only custom key-value pairs.`

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $notification = new \Fcm\Push\Data();
    $notification
        ->addData('test', '123');
        ->addRecipient($deviceId)

    // Shortcut function:
    // $notification = $client->pushData(['key' => 'value'], $deviceId);

    $response = $client->send($notification);

Example response:

.. code-block:: text

    array(5) {
      'multicast_id' =>
      int(76762359248473280622)
      'success' =>
      int(1)
      'failure' =>
      int(0)
      'canonical_ids' =>
      int(0)
      'results' =>
      array(1) {
        [0] =>
        array(1) {
          'message_id' =>
          string(35) "0:1524927061384248%c5f39c08f9fd7ecd"
        }
      }
    }
