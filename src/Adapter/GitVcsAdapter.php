<?php

namespace ConductorGitVcsSupport\Adapter;

use ConductorGitVcsSupport\GitElephant;
use ConductorCore\Repository\RepositoryInterface;
use ConductorGitVcsSupport\Exception;

class GitVcsAdapter implements RepositoryInterface
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
     * @var GitElephant
     */
    private $repository;

    public function setRepoUrl(string $repoUrl): void
    {
        if ($repoUrl != $this->repository) {
            $this->repoUrl = $repoUrl;
            $this->repository = null;
        }
    }

    public function setPath(string $path): void
    {
        if ($path != $this->path) {
            $this->path = $path;
            $this->repository = null;
        }
    }

    private function getRepository()
    {
        if (is_null($this->repository)) {
            $this->repository = new GitElephant\Repository($this->repoUrl);
        }

        return $this->repository;
    }

    public function checkout(string $repoReference): void
    {
//        $this->repository->
//        !file_exists("{$codePath}/.git")

//        if (!file_exists("{$codePath}/.git")) {
//            $this->logger->debug("Cloning repository \"$repoUrl:$repoReference\" to \"{$codePath}\".");
//            $repo = new Repository($codePath);
//            $this->repo->cloneFrom($repoUrl, $codePath);
//            $repo->checkout($repoReference);
//        } else {
//            $repo = new Repository($codePath);
//            if ($repo->isDirty()) {
//                throw new Exception\RuntimeException(
//                    'Code path "' . $codePath . '" is dirty. Clean path before deploying code from repo.'
//                );
//            }
//            $this->logger->debug("Pulling the latest code from \"$repoUrl:$repoReference\" to \"{$codePath}\".");
//            $repo->checkout($repoReference);
//            $repo->pull('origin', $repoReference, false);
//        }
        // TODO: Implement checkout() method.
    }

    public function isClean(): bool
    {
        // TODO: Implement isClean() method.
    }

    public function pull(string $origin, $repoReference): void
    {
        // TODO: Implement pull() method.
    }

    public function stash(string $message): void
    {
//        $repo = new Repository($codeRoot);
//        if ($repo->isDirty()) {
//            $this->logger->info('Stashing code changes.');
//            $repo->stash('Conductor stash', true);
//        }
        // TODO: Implement stash() method.
    }
}
