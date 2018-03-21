<?php

namespace ConductorGitVcsSupport;

return [
    'invokables' => [
        \ConductorCore\Repository\RepositoryAdapterInterface::class => Adapter\GitVcsAdapter::class,
    ],
];
