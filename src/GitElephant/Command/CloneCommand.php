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

use ConductorGitVcsSupport\GitElephant\Repository;

/**
 * Clone command generator
 *
 * This class will be removed once PR https://github.com/matteosister/GitElephant/pull/132 is merged
 *
 * @author Matteo Giachino <matteog@gmail.com>
 * @author Kirk Madera <kmadera@robofirm.com>
 */
class CloneCommand extends \GitElephant\Command\CloneCommand
{
    /**
     * Command to clone a repository
     *
     * @param string $url repository url
     * @param string $to  where to clone the repo
     * @param int|null $depth Depth of commits to clone
     *
     * @throws \RuntimeException
     * @return string command
     */
    public function cloneUrl($url, $to = null, $depth = null)
    {
        $this->clearAll();
        $this->addCommandName(static::GIT_CLONE_COMMAND);
        $this->addCommandSubject($url);
        if (null !== $to) {
            $this->addCommandSubject2($to);
        }

        if (null !== $depth) {
            $this->addCommandArgument('--depth=' . $depth);
            // @todo Add shallow cloning of submodules. Like needs git version check since it's a newer feature
            //if (1 == $depth) {
            //    $this->addCommandArgument('--shallow-submodules');
            //}
        }

        return $this->getCommand();
    }

}
