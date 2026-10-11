Conductor Git VCS Support Documentation
=======================================

This module adds support for Git VCS in   
[Conductor](https://github.com/conductorphp/conductor-core).

## Installation

```bash
composer require conductor/git-vcs-support
```

## Config

Installing the module registers the `git` adapter under `vcs.adapters` in
[conductor/core](https://github.com/conductorphp/conductor-core), and `git` is core's
`vcs.default_adapter`, so nothing needs configuring:

```yaml
vcs:
  default_adapter: git   # core's default; shown for completeness
  adapters:
    git:
      class: ConductorGitVcsSupport\Adapter\GitVcsAdapter   # registered by this module
```

The adapter shells out to `git`, which relies on your shell user's built-in methods for git
authentication. In a future release, we may make configuration of authentication credentials
possible.
