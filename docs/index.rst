.. title:: PHP-FCM, Firebase Cloud Messaging client

=====================
PHP-FCM Documentation
=====================

PHP-FCM is a PHP HTTP client that makes it easy to send push notifications,
manage groups of devices and message topics using Google Firebase Cloud Messaging.

.. code-block:: php

    <?php
    
    // Load composer
    require 'vendor/autoload.php';

    // Instantiate the client with the project api_token and sender_id.
    $client = new \Fcm\FcmClient($apiToken, $senderId);

    // Instantiate the push notification request object.
    $notification = new \Fcm\Push\Notification();

    // Enhance the notification object with our custom options.
    $notification
        ->addRecipient($deviceId)
        ->setTitle('Hello from php-fcm!')
        ->setBody('Notification body')
        ->setColor('#20F037')
        ->setSound("default")
        ->setIcon("myIcon.png")
        ->addData('key', 'value');

    // custom sound and custom icon must be in app package
    //     - custom sound file must be in /res/raw/
    //     - custom icon file must be in drawable resource, if not set, FCM displays launcher icon in app manifest        

    // Send the notification to the Firebase servers for further handling.
    $client->send($notification);


Before installing, read the :doc:`overview` for more information about this project.
Read the :doc:`quickstart` for installation and using the project.

.. toctree::
    :maxdepth: 2

    overview
    quickstart
    integration
    device
    message
    devicegroup
    topic
    packageoptions
