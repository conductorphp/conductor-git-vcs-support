<?php

namespace ConductorGitVcsSupport;

class ConfigProvider
{
    public const ADAPTER_NAME = 'git';

    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'vcs'          => [
                'adapters' => [
                    self::ADAPTER_NAME => [
                        'class' => Adapter\GitVcsAdapter::class,
                    ],
                ],
            ],
        ];
    }

    private function getDependencies(): array
    {
        return require(__DIR__ . '/../config/dependencies.php');
    }
}
