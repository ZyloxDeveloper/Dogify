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

namespace Zylox\Dogify;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Zylox\Dogify\command\DogifyCommand;
use Zylox\Dogify\resource\ResourceManager;
use Zylox\Dogify\thread\ThreadManager;
use const DIRECTORY_SEPARATOR;

class Loader extends PluginBase{
	use SingletonTrait;

	public function onLoad() : void {
		$this->setInstance($this);

		$target = $this->getServer()->getResourcePackManager()->getPath() . DIRECTORY_SEPARATOR . "dogify.zip";
		$source = $this->getResourceFolder() . DIRECTORY_SEPARATOR . "resource_pack";

		new ResourceManager($target, $source);
	}

	public function onEnable() : void {
		new ThreadManager();

		$this->getServer()->getCommandMap()->register("dogify", new DogifyCommand());
	}

	public function onDisable() : void {
		ThreadManager::shutdown();
	}
}
