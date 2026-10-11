<?php

namespace ConductorGitVcsSupport;

// Registered under its own class and selected through core's RepositoryAdapterManager by
// `vcs.adapters.git` (see ConfigProvider). Binding RepositoryAdapterInterface here made this module
// compete with any other VCS module for the interface, last ConfigProvider winning (CTAP-1758).
return [
    'invokables' => [
        Adapter\GitVcsAdapter::class => Adapter\GitVcsAdapter::class,
    ],
];
