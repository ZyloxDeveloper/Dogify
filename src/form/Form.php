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

declare(strict_types = 1);

namespace Zylox\Dogify\form;

use pocketmine\form\Form as IForm;
use pocketmine\player\Player;

abstract class Form implements IForm{

	protected $data = [];
	private $callable;

	public function __construct(?callable $callable) {
		$this->callable = $callable;
	}

	public function sendToPlayer(Player $player) : void {
		$player->sendForm($this);
	}

	public function getCallable() : ?callable {
		return $this->callable;
	}

	public function setCallable(?callable $callable) {
		$this->callable = $callable;
	}

	public function handleResponse(Player $player, $data) : void {
		$this->processData($data);
		$callable = $this->getCallable();
		if($callable !== null) {
			$callable($player, $data);
		}
	}

	public function processData(&$data) : void { }

	public function jsonSerialize() : array{
		return $this->data;
	}
}
