# ChatCommands

ChatCommands is a simple php chat command system.

- Use commands in your chat
- Easy to use

_You can also use this tool for command lines or browser games, for example._

### Installation

Include [`ChatCommands.php`](https://github.com/Teddy95/ChatCommands/blob/master/src/ChatCommands.php) and search the messages for commands.

```php
<?php
	include('ChatCommands.php');

	$chatMessage = '/afk*180 make coffee';

	Teddy95\ChatCommands\cmd::set_character('/'); // Character that initiates the command
	Teddy95\ChatCommands\cmd::set_commands(array('afk', 'dnd', 'lock')); // Commands
	$commandInfo = Teddy95\ChatCommands\cmd::get($chatMessage);

	print_r($commandInfo);
?>
```
Output:

```
Array
(
	[command] => afk
	[text] => make coffee
	[duration] => 180
)
```

A notification in the chat could be the following: "John is away from keyboard for 3 minutes because: make coffee"

Text and Duration are optional!

-------------

### Documentaion

[https://github.com/Teddy95/ChatCommands/wiki](https://github.com/Teddy95/ChatCommands/wiki)

-------------

### Download

- [Releases on Github](https://github.com/Teddy95/ChatCommands/releases)
- **[Download latest version from Github](https://github.com/Teddy95/ChatCommands/archive/v0.3.0.zip)**
- [Download master from Github](https://github.com/Teddy95/ChatCommands/archive/master.zip)

-------------

### Contributors

- [Teddy95](https://github.com/Teddy95)

-------------

### License

The MIT License (MIT) - [View LICENSE.md](https://github.com/Teddy95/ChatCommands/blob/master/LICENSE.md)
