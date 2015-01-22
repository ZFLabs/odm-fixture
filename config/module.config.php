<?php

namespace ZFLabsODMFixture;

return [
    'controllers' => [
        'invokables' => [  __NAMESPACE__.'\Controller\FixtureConsole' => __NAMESPACE__.'\Controller\FixtureController',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'load-fixture-orm' => [
                    'options' => [
                        'route'    => 'odm-fixture [load|check] [--purge]',
                        'defaults' => [
                            'controller' => __NAMESPACE__.'\Controller\FixtureConsole',
                            'action'     => 'index'
                        ]
                    ]
                ]
            ]
        ]
    ]
];