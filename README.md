generator-francis-pyro
===========================

[Francis Bond's](http://francisbond.com) [Yeoman](http://yeoman.io) generator for deploying a [pyro](http://pyro.org) website with [Gulp](http://gulpjs.com/).

## Features

* Generate a Vagrantfile with provisioning via Puppet
* Deploy to a Dokku-powered server
* Copy databases between local and remote environments

## Initialization

* Install: `npm install -g francisbond/generator-francis-pyro`
* Run: `yo francis-pyro`
* Use `gulp deploy-init` to initalise a deployment environment
* Run `gulp deploy` after committing changes to deploy them
* Use `gulp db-push` and `gulp db-pull` to push and pull databases between local and remote environments

### Requirements
* For using the provided development environment, VirtualBox, Vagrant, and the [Vagrant Host Manager](https://github.com/smdahlen/vagrant-hostmanager) plugin must be installed.
* gulp.js should be installed globally via npm.

## Available Commands

### Deployment

* `gulp deploy-init`

  Initialize a Dokku container for use in the project's deployment.

  1. Adds a git remote corresponding with the Dokku server.
  2. Pushes the repository to the Dokku remote.
  3. Defines a Buildpack for Dokku to use in the project's deployment.
  4. Sets up and links a new MariaDB container.

  You should follow this command with gulp db-push.

* `gulp deploy`

  Pushes the repository to the Dokku remote.

* `gulp db-push`

  Dumps the local database to `/.tmp`, and imports it to the linked Dokku MariaDB container.

* `gulp db-pull`

  Dumps the remote Dokku MariaDB database to `/.tmp`, and imports it to the local environment.

* `gulp db-dump`

  Dumps the local and remote databases, and saves them to `/databases`.


  Build the project for deployment. Performs all tasks including minification and image optimization.

### Miscellaneous

* `npm install`

  Install project-specific npm packages defined in the package.json. You should run this command when cloning an already initialized repository.

## Known Issues

* Rerunning `gulp deploy-init` will fail, since a Dokku remote has already been created. Running `git remote remove dokku` will resolve this.
* `gulp deploy` will sometimes fail if a newer commit has been deployed but not pushed to the repository. You can override this by running `git push origin dokku --force`.

## Updating legacy pyro websites

For database deployment functionality to work, the `database.php` file must be updated as follows:

* Any existing database configuration should be removed
* `database-config.php` (created by the generator) should be included
* A `table_prefix` should be set where applicable
* `/public/system/cms/config/database.php` content should be replaced with the below

For example:

```
/** Absolute path to the Pyro directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/../../../');

/** Sets up Pyro database settings. */
require_once(ABSPATH . 'database-config.php');

// Assign the group to be used
$active_group = 'default';
$query_builder = TRUE;

/* End of file database.php */
```
