<?php
/**
 * GitElephant - An abstraction layer for git written in PHP
 * Copyright (C) 2013  Matteo Giachino
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see [http://www.gnu.org/licenses/].
 */

namespace ConductorGitVcsSupport\GitElephant;

use ConductorGitVcsSupport\GitElephant\Command\Caller\Caller;
use GitElephant\Exception;

/**
 * Class Repository
 *
 * @todo Remove this class once https://github.com/matteosister/GitElephant/pull/147 and
 *       https://github.com/matteosister/GitElephant/pull/148 are merged
 * @package ConductorAppOrchestration\GitElephant
 */
class Repository extends \GitElephant\Repository
{
    /**
     * the caller instance
     *
     * @var Caller
     */
    private $caller;

    /**
     * Class constructor
     *
     * @param string         $repositoryPath the path of the git repository
     * @param GitBinary|null $binary         the GitBinary instance that calls the commands
     * @param string         $name           a repository name
     *
     * @throws Exception\InvalidRepositoryPathException
     */
    public function __construct($repositoryPath, GitBinary $binary = null, $name = null)
    {
        parent::__construct($repositoryPath, $binary, $name);
        if (is_null($binary)) {
            $binary = new GitBinary();
        }

        $this->caller = new Caller($binary, $repositoryPath);
    }

    /**
     * Clone a repository
     *
     * @param string      $url           the repository url (i.e. git://github.com/matteosister/GitElephant.git)
     * @param null        $to            where to clone the repo
     * @param string|null $repoReference Repo reference to clone. Required if performing a shallow clone.
     * @param int|null    $depth         Depth to clone repo. Specify 1 to perform a shallow clone
     * @param bool        $recursive     Whether to recursively clone child repos.
     *
     * @throws \RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @return Repository
     */
    public function cloneFrom($url, $to = null, $repoReference = null, $depth = null, $recursive = false)
    {
        $binaryVersion = $this->caller->getBinaryVersion();
        $command = (Command\CloneCommand::getInstance($this))->setBinaryVersion($binaryVersion)
            ->cloneUrl($url, $to, $repoReference, $depth, $recursive);
        $this->caller->execute($command);
        return $this;
    }
}
