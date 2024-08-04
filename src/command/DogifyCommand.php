<?php

/*
 *  ____                    _    __
 * |  _ \    ___     __ _  (_)  / _|  _   _
 * | | | |  / _ \   / _` | | | | |_  | | | |
 * | |_| | | (_) | | (_| | | | |  _| | |_| |
 * |____/   \___/   \__, | |_| |_|    \__, |
 *                  |___/             |___/
 *
 * Copyright 2024 ZyloxDeveloper
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”),
 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author ZyloxDeveloper
 * @link https://github.com/ZyloxDeveloper
 *
 *
 */

declare(strict_types=1);

namespace Zylox\Dogify\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use Zylox\Dogify\form\DogifyForm;
use Zylox\Dogify\Loader;
use Zylox\Dogify\thread\ThreadManager;

class DogifyCommand extends Command implements PluginOwned {

	public function __construct() {
		parent::__construct("dogify", "Veiw a random dog image");
		$this->setPermission('dogify.cmd');
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
		if(!$sender instanceof Player) {
			$sender->sendMessage("You can only use this command in game...");
			return;
		}

		$func = function($url) use ($sender) {
			$sender->sendForm(new DogifyForm($url));
		};

		ThreadManager::addRequest($func);
	}

	public function getOwningPlugin() : Loader {
		return Loader::getInstance();
	}
}
