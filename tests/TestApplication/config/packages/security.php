<?php

use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

$configuration = [
    'enable_authenticator_manager' => true,

    'password_hashers' => [
        User::class => 'plaintext',
        PasswordAuthenticatedUserInterface::class => 'plaintext',
    ],

    'providers' => [
        'test_users' => [
            'memory' => [
                'users' => [
                    'admin' => [
                        'password' => '1234',
                        'roles' => ['ROLE_ADMIN'],
                    ],
                ],
            ],
        ],
    ],

    'firewalls' => [
        'secure_admin' => [
            'pattern' => '^/secure_admin',
            'provider' => 'test_users',
            'http_basic' => null,
            'logout' => null,
        ],
    ],

    'access_control' => [
        ['path' => '^/secure_admin', 'roles' => ['ROLE_ADMIN']],
    ],
];

$container->loadFromExtension('security', $configuration);
