======================
Managing Device Groups
======================

`With device group messaging, you can send a single message to multiple instances of an app running on devices belonging to a group. Typically, "group" refers a set of different devices that belong to a single user. All devices in a group share a common notification key, which is the token that FCM uses to fan out messages to all devices in the group.`
`Read more on at official documentation. <https://firebase.google.com/docs/cloud-messaging/js/device-group>`_

Creating a device group
=======================

When creating a new group, the response will contain a `notification key`, which will be used when adding or removing devices from the group, and sending messages to it.

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $newGroup = new \Fcm\DeviceGroup\Create('phones');
    $newGroup->addDevice($deviceId);

    // Shortcut function:
    // $client->deviceGroupCreate('phones', $deviceId);

    $client->send($newGroup);

Example response:

.. code-block:: text

    array(1) {
      'notification_key' =>
      string(119) "APA91bE8asD44A2gjSUJqRp8Ym4pe7TlrlrSLVkKRBdvkoWOFmusdc87934ASDURl8xaUbXXdKC5DRkUssYtkOl_lnWXT7gF0vO9E666XeL1qJs02FsunJ4"
    }

Adding devices to a group
=========================

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $group = new \Fcm\DeviceGroup\Update('phones', $notificationKey);
    $group->addDevice($deviceId);

    // Shortcut function:
    // $client->deviceGroupUpdate('phones', $notification_key, $deviceId);

    $client->send($group);

Example response:

.. code-block:: text

    array(1) {
      'notification_key' =>
      string(119) "APA91bE8asD44A2gjSUJqRp8Ym4pe7TlrlrSLVkKRBdvkoWOFmusdc87934ASDURl8xaUbXXdKC5DRkUssYtkOl_lnWXT7gF0vO9E666XeL1qJs02FsunJ4"
    }

Removing devices from a group
=============================

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    $group = new \Fcm\DeviceGroup\Remove('phones', $notificationKey);
    $group->addDevice($deviceId);

    // Shortcut function:
    // $client->deviceGroupRemove('phones', $notification_key, $deviceId);

    $client->send($group);

Example response:

.. code-block:: text

    array(1) {
      'notification_key' =>
      string(119) "APA91bE8asD44A2gjSUJqRp8Ym4pe7TlrlrSLVkKRBdvkoWOFmusdc87934ASDURl8xaUbXXdKC5DRkUssYtkOl_lnWXT7gF0vO9E666XeL1qJs02FsunJ4"
    }
