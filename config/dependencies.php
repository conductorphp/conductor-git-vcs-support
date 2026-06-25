<?php

namespace ConductorGitVcsSupport;

use ConductorCore\Repository\RepositoryAdapterInterface;

return [
    'invokables' => [
        RepositoryAdapterInterface::class => Adapter\GitVcsAdapter::class,
    ],
];
