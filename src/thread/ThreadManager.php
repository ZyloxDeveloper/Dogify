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

namespace Zylox\Dogify\thread;

use Closure;
use pmmp\thread\ThreadSafeArray;
use Zylox\Dogify\Loader;

class ThreadManager {

	private static APIThread $thread;
	private static int $id = 0;

	private static array $closures = [];

	public function __construct() {
		$notifer = Loader::getInstance()->getServer()->getTickSleeper()->addNotifier(fn() => self::$thread->collectResults());

		self::$thread = new APIThread($notifer);
	}

	public static function addRequest(Closure $closure) : void {
		$id = self::$id++;

		self::$closures[$id] = $closure;
		self::$thread->addRequest($id);
	}

	public static function shutdown() : void {
		if(isset(self::$thread)) self::$thread->running = false;
	}

	public static function collectResults(ThreadSafeArray $data) : void {
		self::$closures[$data['id']]($data['data']);
	}
}
