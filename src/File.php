<?php

namespace WebChemistry\Utils;

use Nette\IOException;
use Nette\Utils\FileSystem;
use Nette\Utils\ObjectMixin;

/**
 * @property-read int $aTime
 * @property-read string $baseName
 * @property-read string $extension
 * @property-read string $fileName
 * @property-read int $group
 * @property-read int $inode
 * @property-read string $linkTarget
 * @property-read int $mTime
 * @property-read int $owner
 * @property-read string $path
 * @property-read string $pathName
 * @property-read int $perms
 * @property-read string $realPath
 * @property-read int $size
 * @property-read string $type
 */
class File extends \SplFileInfo {

	/** @var string */
	private $file;

	/**
	 * @param string $file
	 */
	public function __construct($file) {
		$this->file = (string) $file;
		parent::__construct($this->file);
	}

	/**
	 * @param string $newName
	 * @param bool $overwrite
	 * @throws IOException
	 */
	public function rename($newName, $overwrite = TRUE) {
		FileSystem::rename($this->file, $newName, $overwrite);
	}

	/**
	 * @param string $destination
	 * @param bool $overwrite
	 * @throws IOException
	 */
	public function copy($destination, $overwrite = TRUE) {
		FileSystem::copy($this->file, $destination,$overwrite);
	}

	/**
	 * @throws IOException
	 */
	public function delete() {
		if ($this->exists()) {
			FileSystem::delete($this->file);
		}
	}

	/**
	 * @return string
	 */
	public function read() {
		if (($content = @file_get_contents($this->file)) === FALSE) {
			throw new IOException("Unable to read file '" . $this->file ."'.");
		}

		return $content;
	}

	/**
	 * @param bool $need
	 * @return bool
	 * @throws IOException
	 */
	public function exists($need = FALSE) {
		$exists = file_exists($this->file);
		if ($need && !$exists) {
			throw new IOException('File "' . $this->getRealPath() . '" not exists.');
		}

		return $exists;
	}

	/**
	 * @param string $content
	 * @param int $flags
	 * @param int $mode
	 */
	public function write($content, $flags = NULL, $mode = 0777) {
		$file = $this->file;
		if (@file_put_contents($file, $content, $flags) === FALSE) {
			throw new IOException("Unable to write file '$file'.");
		}
		if ($mode !== NULL && !@chmod($file, $mode)) {
			throw new IOException("Unable to chmod file '$file'.");
		}
	}

	/**
	 * @param string $path
	 * @throws IOException
	 */
	private function createDirs($path, $mode) {
		$create = array();
		while (!file_exists($path)) {
			array_unshift($create, $prev = $path);
			$path = dirname($path);
			if ($prev === $path) {
				break;
			}
		}

		foreach ($create as $directory) {
			FileSystem::createDir($directory, $mode);
		}
	}

	/**
	 * @param bool $isFile
	 * @param int $mode
	 * @throws IOException
	 */
	public function mkDirs($isFile = FALSE, $mode = 0777) {
		$this->createDirs($isFile ? dirname($this->file) : $this->file, $mode);
	}

	/**
	 * @param int $mode
	 */
	public function mkDir($mode = 0777) {
		FileSystem::createDir($this->file, $mode);
	}

	/**
	 * @param mixed $name
	 * @return mixed
	 */
	public function __get($name) {
		return ObjectMixin::get($this, $name);
	}

}
