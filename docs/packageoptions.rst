===============
Package Options
===============

Package options allow you to set options used within calls in the package. Package options can be configured in two ways.  


Options
====================

Options are set as an array.  Options can be set on client instantiation or on an already created client.

.. code-block:: php

    <?php
    $options = Array("http_errors" => true);
    ?>


Currently only one option is supported.  

For any other sugestions for options, please add an issue to https://github.com/EdwinHoksberg/php-fcm/issues describing the new option.


Setting on instantiation
====================

Settings options on instance creation is done as follows.

.. code-block:: php

    <?php

    $options = Array("http_errors" => true);
    $client = new \Fcm\FcmClient($serverKey, $senderId, $options);


Setting after instantiation
====================

Options can be set after instantiation using the `setOptions` function passing in an options array.

.. code-block:: php

    <?php

    $client = new \Fcm\FcmClient($serverKey, $senderId);

    # some code using the client

    $options = Array("http_errors" => true);
    $client->setOptions($options);

    # some more code using the client

    $options = Array("http_errors" => false);
    $client->setOptions($options);


http_errors option
====================

The `http_errors` option exposes the Guzzle `http_errors` parameter.  By default, a HTTP error in Guzzle will cause an exception, so will terminate your code.  By setting `http_errors` to `false` a HTTP error will not result in an exception.

An example of setting the options array might look like this.

.. code-block:: php

    <?php

    $options = Array("http_errors" => true);

Guzzle is the underlying library used by php-fcm, see http://docs.guzzlephp.org/en/stable/ for more details.

The `http-errors` option is described at http://docs.guzzlephp.org/en/stable/request-options.html#http-errors