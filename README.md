# Shell

[![Build Status](https://travis-ci.org/ilya-dev/shell.svg?branch=master)](https://travis-ci.org/ilya-dev/shell)

> Some more details and documentation will be posted later

```php

use Shell\Shell;

Shell::ls()->endChain(); // ls

(string) Shell::ls() // ls

echo Shell::ls()->grep("some-pattern", ['f', 'switch', 'option' => 'value']);
// ls | grep 'some-pattern' -f --switch --option='value'

Shell::startChain('your-custom-command')->endChain(); // your-custom-command

```
