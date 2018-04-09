================
Sending Messages
================

There are two different types of messages Firebase can support, `Notification messages` and `Data messages`.
Read `here <https://firebase.google.com/docs/cloud-messaging/concept-options>`_ for more information.

Notification message
====================

`FCM automatically displays the message to end-user devices on behalf of the client app. Notification messages have a predefined set of user-visible keys and an optional data payload of custom key-value pairs.`

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $notification = new \Fcm\Push\Notification();
    $notification
        ->setTitle('Hello from php-fcm!')
        ->addRecipient($deviceId);

    // Shortcut function:
    // $notification = $client->pushNotification('The title', 'The body', $deviceId);

    $response = $client->send($notification);

Example response:

.. code-block:: text

    array(5) {
      'multicast_id' =>
      int(9014353506250345342)
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
          string(35) "0:154231004164960%c5f39c08c5f39c543"
        }
      }
    }

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
