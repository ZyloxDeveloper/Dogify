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

use pmmp\thread\ThreadSafeArray;
use pocketmine\snooze\SleeperHandlerEntry;
use pocketmine\thread\Thread;
use function curl_exec;
use function curl_init;
use function curl_setopt;
use function json_decode;
use const CURLOPT_HTTPGET;
use const CURLOPT_HTTPHEADER;
use const CURLOPT_RETURNTRANSFER;
use const CURLOPT_SSL_VERIFYPEER;

class APIThread extends Thread {

	private SleeperHandlerEntry $notifier;
	public ThreadSafeArray $results;
	public ThreadSafeArray $queue;
	public bool $running = true;

	public function __construct(SleeperHandlerEntry $notifier) {
		$this->notifier = $notifier;

		$this->results = new ThreadSafeArray();
		$this->queue = new ThreadSafeArray();

		$this->start();
	}

	public function onRun() : void {
		$notifier = $this->notifier->createNotifier();

		while($this->running) {
			while(($data = $this->queue->shift()) !== null) {
				$ch = curl_init("https://dog.ceo/api/breeds/image/random");
				curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				$response = curl_exec($ch);

				if(!isset(json_decode($response, true)['status'])) continue;

				$data = [
					"id" => $data,
					"data" => json_decode($response, true)['message']
				];

				$this->results[] = ThreadSafeArray::fromArray($data);
			}

			$notifier->wakeupSleeper();
		}
	}

	public function addRequest(int $id) : void {
		$this->queue[] = $id;
	}

	public function collectResults() : void {
		while(($result = $this->results->shift()) !== null) {
			ThreadManager::collectResults($result);
		}
	}
}
