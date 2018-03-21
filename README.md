Conductor: Git VCS Support
===============================================

This module adds support for Git VCS in   
[Conductor](https://github.com/conductorphp/conductor-core).

## Config

```php

<?php

return [
    'vcs' => [
        'adapters' => [
            'github' => [
                'class' => \ConductorGitVcsSupport\Adapter\GitVcsAdapter::class,
                'arguments' => [
                    'ssh_private_key' => '/home/dev/.ssh/id_rsa',
                ],
            ],
        ],
    ],
];
```
