<?php

$configuration = [
    'secret' => 'F00',
    'csrf_protection' => true,
    'session' => [
        'handler_id' => null,
        'storage_id' => 'session.storage.mock_file',
        'storage_factory_id' => 'session.storage.factory.mock_file',
    ],
    'test' => true,
];

$container->loadFromExtension('framework', $configuration);
