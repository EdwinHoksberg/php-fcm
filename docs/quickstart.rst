==========
Quickstart
==========

Installing this package
=======================

This package is available on packagist, and can be installed with composer:

.. code-block:: bash

    composer require edwinhoksberg/php-fcm

Configuring a Firebase account
==============================

This project uses Google Firebase for sending notifications, so we need to signup for an free account.
A free account can store up to ~20 million messages, device groups and topics.

#. Click `here <https://console.firebase.google.com/>`_ to go the firebase console page.
#. Click on the Create Project button. Enter a project name and select your country/region.
#. Once your project is created, click on continue to go to the project dashboard.
#. Click on the gear icon in the top left, next to the Project Overview link, and click on Project Settings.
#. Go to the Cloud Messaging tab.
#. On this page, you should see several authentication tokens. Copy and save the `Server key` and `Sender ID` tokens somewhere. These will be used in the project configuration.

Configuring the project
=======================

When you instantiate a new Firebase Cloud Messaging object, pass the `Server Key` and `Sender ID` you retrieved from the previous steps:

.. code-block:: php

    <?php
    
    // Load composer
    require 'vendor/autoload.php';

    $client = new \Fcm\FcmClient(/* Server Key */, /* Sender ID */);
