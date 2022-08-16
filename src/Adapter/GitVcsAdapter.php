<?php

namespace ConductorGitVcsSupport\Adapter;

use ConductorCore\Repository\RepositoryAdapterInterface;
use ConductorGitVcsSupport\Exception;
use ConductorGitVcsSupport\GitElephant\Repository;

class GitVcsAdapter implements RepositoryAdapterInterface
{
    /**
     * @var string
     */
    private $repoUrl;
    /**
     * @var string
     */
    private $path;
    /**
     * @var Repository
     */
    private $repository;
    /**
     * @var string
     */
    private $currentRepoReference;

    /**
     * @inheritdoc
     */
    public function checkout(string $repoReference, bool $shallow = false): void
    {
        if ($repoReference == $this->currentRepoReference) {
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
     * @inheritdoc
     */
    public function isClean(): bool
    {
        $repository = $this->getRepository();
        return !$repository->isDirty();
    }

    /**
     * @inheritdoc
     */
    public function pull(): void
    {
        $repository = $this->getRepository();
        $repository->pull();
    }

    /**
     * @inheritdoc
     */
    public function stash(string $message): void
    {
        $repository = $this->getRepository();
        $repository->stash($message, true);
    }

    /**
     * @inheritdoc
     */
    public function setRepoUrl(string $repoUrl): void
    {
        $this->repoUrl = $repoUrl;
    }

    /**
     * @inheritdoc
     */
    public function setPath(string $path): void
    {
        if ($path != $this->path) {
            $this->path = $path;
            $this->repository = null;
        }
    }

    /**
     * @return Repository
     */
    private function getRepository(): Repository
    {
        if (is_null($this->repository)) {
            $this->repository = new Repository($this->path);
        }

        return $this->repository;
    }

}
