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

namespace ConductorGitVcsSupport\GitElephant\Command;

/**
 * Clone command generator
 *
 * @todo Remove this class once https://github.com/matteosister/GitElephant/pull/148 is merged
 *
 * @author Matteo Giachino <matteog@gmail.com>
 * @author Kirk Madera <kirk.madera@rmgmedia.com>
 */
class CloneCommand extends \GitElephant\Command\CloneCommand
{
    /**
     * @var string
     */
    private $binaryVersion;

    /**
     * @param $version
     *
     * @return $this
     */
    public function setBinaryVersion($version)
    {
        $this->binaryVersion = $version;
        return $this;
    }

    /**
     * Command to clone a repository
     *
     * @param string      $url           repository url
     * @param string      $to            where to clone the repo
     * @param string|null $repoReference Repo reference to clone. Required if performing a shallow clone.
     * @param int|null    $depth         Depth of commits to clone
     * @param bool    $recursive         Whether to recursively clone submodules.
     *
     * @throws \RuntimeException
     * @return string command
     */
    public function cloneUrl($url, $to = null, string $repoReference = null, int $depth = null, bool $recursive = false)
    {
        $this->clearAll();
        $this->addCommandName(static::GIT_CLONE_COMMAND);
        $this->addCommandSubject($url);
        if (null !== $to) {
            $this->addCommandSubject2($to);
        }

        if (null !== $repoReference) {
            // git documentation says the --branch was added in 2.0.0, but it exists undocumented at least back to 1.8.3.1
            if (version_compare($this->binaryVersion, '1.8.3.1', '<')) {
                throw new \RuntimeException('Please upgrade to git v1.8.3.1 or newer to support cloning a specific branch.');
            }
            $this->addCommandArgument('--branch=' . $repoReference);
        }

        if (null !== $depth) {
            $this->addCommandArgument('--depth=' . $depth);
            // shallow-submodules is a nice to have feature. Just ignoring if git version not high enough
            // It would be nice if this had a logger injected for us to log notices
            if (version_compare($this->binaryVersion, '2.9.0', '>=') && $recursive && 1 == $depth) {
                $this->addCommandArgument('--shallow-submodules');
            }
        }

        if ($recursive) {
            $this->addCommandArgument('--recursive');
        }

        return $this->getCommand();
    }

}
