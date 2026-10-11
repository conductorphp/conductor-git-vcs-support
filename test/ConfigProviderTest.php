<?php

namespace ConductorGitVcsSupportTest;

use ConductorCore\Repository\RepositoryAdapterInterface;
use ConductorGitVcsSupport\Adapter\GitVcsAdapter;
use ConductorGitVcsSupport\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    private ConfigProvider $configProvider;

    public function setUp(): void
    {
        $this->configProvider = new ConfigProvider();
    }

    public function testInvoke(): void
    {
        $configProvider = $this->configProvider;
        $this->assertIsArray($configProvider());
    }

    public function testRegistersTheGitAdapterUnderItsOwnName(): void
    {
        $config = ($this->configProvider)();

        $this->assertSame(GitVcsAdapter::class, $config['vcs']['adapters']['git']['class']);
        $this->assertTrue(is_a(GitVcsAdapter::class, RepositoryAdapterInterface::class, true));
    }

    public function testDoesNotBindACoreInterface(): void
    {
        $dependencies = ($this->configProvider)()['dependencies'];
        $this->assertIsArray($dependencies);

        foreach (['aliases', 'factories', 'invokables', 'services', 'delegators'] as $section) {
            foreach (array_keys($dependencies[$section] ?? []) as $serviceName) {
                $this->assertFalse(
                    interface_exists($serviceName) && str_starts_with($serviceName, 'ConductorCore\\'),
                    "dependencies.$section binds $serviceName; register the adapter under vcs.adapters instead",
                );
            }
        }
    }
}
