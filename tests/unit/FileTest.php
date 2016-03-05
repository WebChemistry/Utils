<?php

use WebChemistry\Utils\File as File;

class FileTest extends \Codeception\TestCase\Test {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	/** @var string */
	protected $basePath;

	protected function _before() {
		$this->basePath = __DIR__ . '/../_data/other';
	}

	protected function _after() {
		Util::cleanAll($this->basePath);
	}

	public function testExists() {
		$file = new File(__FILE__);
		$this->assertTrue($file->exists());
		$file->exists(TRUE);

		$file = new File(__DIR__ . '/notExists.php');
		$this->assertFalse($file->exists());

		$this->tester->assertExceptionThrown('Nette\IOException', function () use ($file) {
			$file->exists(TRUE);
		});
	}

	public function testMagicMethods() {
		$file = new File(__FILE__);

		$this->assertSame($file->getPath(), $file->path);
	}

	public function testMkDirs() {
		$file = new File($this->basePath . '/directory/directory2');
		$file->mkDirs();

		$this->assertFileExists($this->basePath . '/directory/directory2');
		$file->mkDirs();
	}

	public function testRead() {
		$file = new File(__FILE__);
		$this->assertSame(file_get_contents(__FILE__), $file->read());

		$file = new File(__DIR__ . '/notExists.php');
		$this->tester->assertExceptionThrown('Nette\IOException', function () use ($file) {
			$file->read();
		});
	}

	public function testWrite() {
		$file = new File($this->basePath . '/file.txt');
		$file->write('asd');
		$this->assertFileExists($this->basePath . '/file.txt');
		$this->assertSame(file_get_contents($this->basePath . '/file.txt'), $file->read());

		$file = new File($this->basePath . '/dir/dir/file.txt');
		$this->tester->assertExceptionThrown('Nette\IOException', function () use ($file) {
			$file->write('asd');
		});
		$this->assertFileNotExists($this->basePath . '/dir/dir/file.txt');
	}

	public function testRename() {
		$file = new File($this->basePath . '/file.txt');
		$file->write('asd');
		$file->rename($this->basePath . '/fileNew.txt');

		$this->assertFileExists($this->basePath . '/fileNew.txt');
		$this->assertFileNotExists($this->basePath . '/file.txt');
		$this->assertSame('asd', file_get_contents($this->basePath . '/fileNew.txt'));
	}

	public function testCopy() {
		$file = new File($this->basePath . '/file.txt');
		$file->write('asd');
		$file->copy($this->basePath . '/fileNew.txt');

		$this->assertFileExists($this->basePath . '/fileNew.txt');
		$this->assertFileExists($this->basePath . '/file.txt');
		$this->assertSame($file->read(), file_get_contents($this->basePath . '/fileNew.txt'));
	}

	public function testDelete() {
		$file = new File($this->basePath . '/file.txt');
		$file->write('asd');

		$this->assertFileExists($this->basePath . '/file.txt');

		$file->delete();
		$this->assertFileNotExists($this->basePath . '/file.txt');

		$file = new File(__DIR__ . '/notExists.php');
		$file->delete();

		$file = new File($this->basePath . '/dir');
		$file->mkDir();
		$this->assertFileExists($this->basePath . '/dir');

		$file->delete();
		$this->assertFileNotExists($this->basePath . '/dir');
	}

}
