# Shell

[![Build Status](https://travis-ci.org/ilya-dev/shell.svg?branch=master)](https://travis-ci.org/ilya-dev/shell)

**Shell** makes it easier to build various...shell commands!

## Documentation

Shell helps you build complex commands. Note that it **will not** execute them, but prepare and let you do the rest manually.


To start building, reference the desired command like so:

```php
Shell::ls(); // ls
```

If the command contains dashes, use `startChain`:

```php
Shell::startChain('very-complex-command'); // very-complex-command
```

If you want to pass some *arguments*, feel free to do that:

```php
Shell::ls('my-epic-dir'); // ls 'my-epic-dir'
```

*Options* and *flags*? Couldn't be simpler, just pass an array as the argument:

```php
Shell::ls('my-epic-dir', ['w', 's' => 'foo', 'bar' => 'baz']);
// ls 'my-epic-dir' -w -s='foo' --bar='baz'
```

Done? Use `endChain` or just convert the object to a string:

```php
(string) Shell::ls('my-epic-dir', ['w', 's' => 'foo', 'bar' => 'baz']);

// or...

Shell::ls('my-epic-dir', ['w', 's' => 'foo', 'bar' => 'baz'])->endChain();
```


All right, you've successfully built your first command!

## Example

```php

use Shell\Shell;

Shell::ls()->endChain(); // ls

(string) Shell::ls() // ls

echo Shell::ls()->grep("some-pattern", ['f', 'switch', 'option' => 'value']);
// ls | grep 'some-pattern' -f --switch --option='value'

Shell::startChain('your-custom-command')->endChain(); // your-custom-command

```

## License

Shell is licensed under the MIT license.

