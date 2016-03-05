<?php

require __DIR__ . '/../vendor/autoload.php';

@mkdir(__DIR__ . '/_data/other');

class Util {

	/**
	 * @param string $dir
	 */
	public static function cleanAll($dir) {
		foreach (\Nette\Utils\Finder::findFiles('*')->from($dir) as $file) {
			unlink($file);
		}
		$array = iterator_to_array(\Nette\Utils\Finder::findDirectories('*')->from($dir));
		usort($array, function ($a, $b) {
			$aC = substr_count($a, '/') + substr_count($a, '\\');
			$bC = substr_count($b, '/') + substr_count($b, '\\');

			return $aC === $bC ? 0 : ($aC < $bC ? 1 : -1);
		});
		foreach ($array as $file) {
			rmdir($file);
		}
	}

}
