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
        ->setBadge(11)
        ->addData("key","value");

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
        ->setIcon("myIcon.png")
        ->addDataArray($myObjArray);

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
         // In Android 6 and lower - this the background color of the icon image when you pull down on the status bar messages
         // In Android 7 and greater - this is the color of the icon itself when you pull down on the status bar messages
     * setIcon (string)
         // custom icon file must be in app itself
         // icon must be drawable resource, if not set, FCM displays launcher icon in app manifest
         // for consistency across Android OS versions(5.0 - 10.0), use a material design, transparent icon
         // if using icon in `drawable-XYdi` folders, use icon name without file extension, ie: ->setIcon('myIcon')
         // if using icon from other location, you must specificy the file extension, ie: ->setIcon('www/images/thisIcon.png') 
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
     
     //NOTE: You can mix and match iOS and Android only options in same notification
     //NOTE: if iOS/Android don't recognize an option used in the other platform, that option is simply discarded/ignored.
     
Notification DATA options <topics> <deviceID> <registered_ids>
====================
`Client app is responsible for processing data messages. Data messages require custom key-value pairs that your app will understand.`

.. code-block:: text

    * addData("key","value") - add data key/values one at a time
    * addDataArray(array_of_keyValues) - add data as a prebuilt object array
        //     $fcmData = array(
        //          'action' => 2,
        //          'dataTitle' => "This is my subject line",
        //          'dataMsg' => "This is the body of my message
        
        // Example, In a cordova based app using `cordova-plugin-firebase`
        window.FirebasePlugin.onNotificationOpen(function(payload) {
            // if there is a payload it will be in payload object
            if (payload.action == 1) { // email verification confirmation
              setDB("user_emailVerify",payload.user_emailVerify) ;
              alert("Thank you, your email address has now been verified") ;
            } else if (payload.action == 2) {  // display gen message
              alert(payload.dataTitle+ "\n" +payload.dataMsg) ;
            }
        }, function(error) {
          console.error(error);
        }) ;
        
        // NOTE: you can mix/use ->addDataArray(array()) and ->addData("key","value") in same notification
        // NOTE: pass in preset array, then add a few extra custom key/values.


Data Only message
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
