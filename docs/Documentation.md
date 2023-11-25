Welcome to the php-package-template documentation!

Here are the main guidelines for developing redistributable PHP packages at DataLinx.

<!-- TOC -->
  * [Conventional Commits](#conventional-commits)
    * [Setting up in an existing project](#setting-up-in-an-existing-project)
    * [Types](#types)
  * [Release Please](#release-please)
  * [Code style and formatting](#code-style-and-formatting)
  * [Testing, debugging and code coverage](#testing-debugging-and-code-coverage)
    * [Configuring an existing project](#configuring-an-existing-project)
    * [Running tests](#running-tests)
<!-- TOC -->

## Conventional Commits

✅️ All VCS commits must adhere to the Conventional Commits specification.

Conventional Commits is a specification for adding human and machine-readable meaning to commit messages.
It is based on the [Semantic Versioning](https://semver.org/) specification.
You can read more about it on [conventionalcommits.org](https://www.conventionalcommits.org/).

Conventional commit messages are locally enforced by using [commitlint](https://commitlint.js.org/) and a git hook (by using Husky).
They are required for the release-please GitHub action, which automatically creates pull requests for new releases with the updated changelog.

### Setting up in an existing project

* Run these commands to add the npm packages and the git hook:
```shell
npm install --save-dev @commitlint/{cli,config-conventional} husky
echo "module.exports = { extends: ['@commitlint/config-conventional'] };" > commitlint.config.js
npx husky install
npx husky add .husky/commit-msg  'npx --no -- commitlint --edit ${1}'
```
* Add `husky install` to the npm `prepare` script, so it runs when `npm install` is first run after a developer clones your package VCS repository:
```
  "scripts": {
    "prepare": "husky install"
  }
```
### Types
This is a list with commit types and their example scopes within our packages:
* `build`: changing files that are related to package development and distribution tools (e.g. lando, npm, vite...) and updating external dependencies (e.g. laravel/framework, league/csv...)
* `ci`: changes for Continuous integration / GitHub actions (e.g. tests, codecov, fix-code-style...)
* `chore`: all other changes that are irrelevant to downstream (e.g. .gitignore, .editorconfig...)
* `docs`: documentation only changes (e.g. README)
* `feat`: adding a new feature, increases the `MINOR` number on release
* `fix`: fixing a bug, increases the `PATCH` number on release
* `perf`: a code change that improves performance
* `refactor`: a code change that neither fixes a bug nor adds a feature
* `revert`: a commit that reverts changes by a previous commit. Message should include the exact message of the reverted commit, e.g.: `revert: build(npm): add prepare script`.
* `style`: changes that do not affect the meaning of the code (white-space, formatting, missing semicolons, etc.)
* `test`: Adding missing tests or correcting existing tests

The above is mostly copied from [Angular](https://github.com/angular/angular/blob/22b96b9/CONTRIBUTING.md#-commit-message-guidelines).

## Release Please

✅️️ The [release-please](https://github.com/google-github-actions/release-please-action) GitHub workflow is used to automatically:
* Create pull requests for new releases
* Update the `CHANGELOG.md` file
* [Semantically version](https://semver.org/) the package

See the `.github/workflows/release-please.yml` for the configuration. Only the `package-name` parameter needs to be changed.

## Code style and formatting

✅️ [PSR-12](https://www.php-fig.org/psr/psr-12) is observed and [Laravel Pint](https://github.com/laravel/pint) is used for source code linting.

To set it up in an existing project:
* Follow the [official documentation](https://laravel.com/docs/pint) to install the package
* Add the following to the `scripts` section of `composer.json`:
```
"scripts": {
    "format": "vendor/bin/pint"
}
```

## Testing, debugging and code coverage

✅️ The package should:
* be tested with [Pest](https://pestphp.com/),
* have a fully integrated testing and debugging experience in the PhpStorm IDE,
* have a high code coverage (ideally 100%, but not at the expense of the common practical sense),
* have a CI testing workflow.

Prerequisites:
* PhpStorm
* Pest PhpStorm plugin - to install it, go to `Settings > Plugins > Marketplace` and search for `Pest`

By creating your package from this template, you will get a fully configured PhpStorm project with Pest, Xdebug and a test runner set up and ready to go.

Also, `test-runner.yml` is included in the `.github/workflows` directory, which you can use as a starting point for your CI testing workflow.

### Configuring an existing project
1. Add Pest to the project. See the [Pest documentation](https://pestphp.com/docs/installation) for installation instructions.
2. Configure PhpStorm for testing and debugging. This is a bit more involved, so it's described in detail on the [Testing with PhpStorm](Testing%20with%20PhpStorm.md) page. 
3. Create a `test` script in `composer.json`:
    ```
    "scripts": {
        "test": "vendor/bin/pest"
    }
    ```
4. Create a `test` tooling entry in the `.lando.dist.yml` file:
    ```
    tooling:
      test:
        service: appserver
        description: Run tests
        cmd: composer test
    ```
5. Copy and configure the `test-runner.yml` GitHub workflow file from this template to your project.

### Running tests
There are different ways to run tests:
* Running test runners from the IDE — use the IDE buttons or keyboard shortcuts.
* Locate a specific test in the test file and press `Alt+Enter` to run it in the IDE tool window. The IDE creates a temporary test runner for this.
* Run tests from the CLI:
    ```shell
    lando test
    ```
    ... or when in the container (or in a CI workflow):
    ```shell
    composer test
    ```
    If you want to use the `--filter` parameter, you have to call Pest directly inside the container:
    ```shell
    ./vendor/bin/pest --filter=MyTest
    ```
