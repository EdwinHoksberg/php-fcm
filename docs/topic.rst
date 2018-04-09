============================
Managing Notification Topics
============================

`Based on the publish/subscribe model, FCM topic messaging allows you to send a message to multiple devices that have opted in to a particular topic. You compose topic messages as needed, and FCM handles routing and delivering the message reliably to the right devices.`

`For example, users of a local weather forecasting app could opt in to a "severe weather alerts" topic and receive notifications of storms threatening specified areas. Users of a sports app could subscribe to automatic updates in live game scores for their favorite teams.`

Read `here <https://firebase.google.com/docs/cloud-messaging/admin/manage-topic-subscriptions>`_ for more information.

Subscribing to a topic
======================

When a topic does not exist, you can still subscribe to it, and the topic will be automaticly created.

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $subscribe = new \Fcm\Topic\Subscribe('my_topic_name');
    $subscribe->addDevice($deviceId);

    // Shortcut function:
    // $client->topicSubscribe('my_topic_name', $deviceId);

    $client->send($subscribe);

Example response:

.. code-block:: text

    // When an error occurs, this will be filled with the message.
    array(1) {
      'results' =>
      array(1) {
        [0] =>
        array(0) {
        }
      }
    }

Unsubscribing from a topic
==========================

Just like creating a topic, a topic will be automaticly deleted once all devices are unsubscribed from it.

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $unsubscribe = new \Fcm\Topic\Unsubscribe('my_topic_name');
    $unsubscribe->addDevice($deviceId);

    // Shortcut function:
    // $client->topicUnsubscribe('my_topic_name', $deviceId);

    $client->send($unsubscribe);

Example response:

.. code-block:: text

    // When an error occurs, this will be filled with the message.
    array(1) {
      'results' =>
      array(1) {
        [0] =>
        array(0) {
        }
      }
    }
