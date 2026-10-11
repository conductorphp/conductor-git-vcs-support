<?php

namespace ConductorGitVcsSupport\Adapter;

use ConductorCore\Repository\RepositoryAdapterInterface;
use ConductorCore\Runtime\Requirement;
use ConductorCore\Runtime\RuntimeRequirementsInterface;
use ConductorGitVcsSupport\Exception;
use GitElephant\Repository;

class GitVcsAdapter implements RepositoryAdapterInterface, RuntimeRequirementsInterface
{
    private string $repoUrl;
    private string $path;
    private ?Repository $repository = null;
    private ?string $currentRepoReference = null;

    /**
     * GitElephant shells out to git; without it every call died with exit 127 (CTAP-1738). Checked by
     * core's RepositoryAdapterManager when this adapter is selected (CTAP-1759).
     *
     * @return list<Requirement>
     */
    public function runtimeRequirements(): array
    {
        return [Requirement::binary('git', 'the git package')];
    }

    public function checkout(string $repoReference, bool $shallow = false): void
    {
        if ($repoReference === $this->currentRepoReference) {
            return;
        }

        $repository = $this->getRepository();
        if (!file_exists("{$this->path}/.git")) {
            $depth = $shallow ? 1 : null;
            $repository->cloneFrom($this->repoUrl, $this->path, $repoReference, $depth, true);
//            $repository->checkout($repoReference);
        } else {
            if ($repository->isDirty()) {
                throw new Exception\RuntimeException(
                    'Code path "' . $this->path . '" is dirty. Clean path before deploying code from repo.'
                );
            }
            $repository->fetch();
            $repository->checkout($repoReference);
        }
    }

    /**
     * Returns existing repository or creates a new one based on path
     */
    private function getRepository(): Repository
    {
        if (is_null($this->repository)) {
            $this->repository = new Repository($this->path);
        }

        return $this->repository;
    }

    public function isClean(): bool
    {
        $repository = $this->getRepository();
        return !$repository->isDirty();
    }

    public function pull(): void
    {
        $repository = $this->getRepository();
        $repository->pull();
    }

    public function stash(string $message): void
    {
        $repository = $this->getRepository();
        $repository->stash($message, true);
    }

    public function setRepoUrl(string $repoUrl): void
    {
        $this->repoUrl = $repoUrl;
    }

    public function setPath(string $path): void
    {
        if (!isset($this->path) || $path !== $this->path) {
            $this->path = $path;
            $this->repository = null;
        }
    }

}
