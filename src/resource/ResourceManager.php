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

namespace Zylox\Dogify\resource;

use pocketmine\resourcepacks\ZippedResourcePack;
use ReflectionClass;
use ZipArchive;
use Zylox\Dogify\Loader;
use function file_exists;
use function is_dir;
use function scandir;
use function unlink;
use const DIRECTORY_SEPARATOR;

class ResourceManager {

	public function __construct(string $target, string $source) {
		if(file_exists($target)) unlink($target);
		self::buildResourcePack($source, $target);

		$rpm = Loader::getInstance()->getServer()->getResourcePackManager();
		$rp = new ZippedResourcePack($target);
		$refl = new ReflectionClass($rpm);

		$property = $refl->getProperty("resourcePacks");
		$property->setAccessible(true);

		$currentResourcePacks = $property->getValue($rpm);
		$currentResourcePacks[] = $rp;
		$property->setValue($rpm , $currentResourcePacks);

		$property = $refl->getProperty("serverForceResources");
		$property->setAccessible(true);
		$property->setValue($rpm , true);
	}

	public static function buildResourcePack(string $source, string $target) : void {
		$zipArchive = new ZipArchive();
		$zipArchive->open($target, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		self::recurseDirectoryToZip($source, $zipArchive);

		$zipArchive->close();
	}

	public static function recurseDirectoryToZip(string $path, ZipArchive $zipArchive, string $localDir = "") : void {
		foreach(scandir($path) as $item) {
			if($item == "." || $item == "..") continue;

			$itemPath = $path . DIRECTORY_SEPARATOR . $item;
			($localDir == "") ? $localFile = $item : $localFile = $localDir . DIRECTORY_SEPARATOR . $item;

			if(!is_dir($path . DIRECTORY_SEPARATOR . $item)) {
				$zipArchive->addFile($itemPath, $localFile);
				continue;
			}

			$zipArchive->addEmptyDir($localFile);
			self::recurseDirectoryToZip($itemPath, $zipArchive, $localFile);
		}
	}
}
