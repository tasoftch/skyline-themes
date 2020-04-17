<?php
/**
 * BSD 3-Clause License
 *
 * Copyright (c) 2020, TASoft Applications
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 *  Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 *  Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

namespace Skyline\Themes\Repository;


use Skyline\Themes\Repository\Loader\FileLoaderPreFilterInterface;
use Skyline\Themes\Repository\Loader\FileLoaderInterface;
use Skyline\Themes\Repository\Loader\LoaderInterface;
use Skyline\Themes\Theme\ThemeInterface;
use TASoft\Service\Exception\FileNotFoundException;
use TASoft\Util\RealPathTool;

class DirectoryRepository extends AbstractRepository
{
	/** @var string */
	private $directoryName;

	/**
	 * DirectoryRepository constructor.
	 * @param string $directoryName
	 * @param bool $recursiveSearching
	 */
	public function __construct(string $directoryName)
	{
		if(!is_dir($directoryName)) {
			$e = new FileNotFoundException("Directory ".basename($directoryName)." does not exist");
			$e->setFilename($directoryName);
			throw $e;
		}
		$this->directoryName = $directoryName;
	}

	/**
	 * @inheritDoc
	 */
	public function addLoader(LoaderInterface $loader, string $filePattern = "")
	{
		$this->loaders[$filePattern] = $loader;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function removeLoader(LoaderInterface $loader = NULL, string $filePattern = NULL)
	{
		if($filePattern !== NULL)
			unset($this->loaders[$filePattern]);
		if($loader !== NULL)
			parent::removeLoader($loader);
		return $this;
	}

	/**
	 * Tries to find a loader matching for a filename
	 *
	 * @param string $basename
	 * @return LoaderInterface|null
	 */
	public function getLoader(string $filename): ?LoaderInterface {
		foreach($this->getLoaders() as $pattern => $loader) {
			if($loader instanceof FileLoaderInterface) {
				if($loader->canLoad($filename)) {
					return $loader;
				}
				continue;
			}

			if(fnmatch($pattern, basename($filename)))
				return $loader;
		}
		return NULL;
	}

	/**
	 * @return string
	 */
	public function getDirectoryName(): string
	{
		return $this->directoryName;
	}

	protected function yieldFiles(): \Generator {
		foreach(new \DirectoryIterator($this->getDirectoryName()) as $file)
			yield $file;
	}

	/**
	 * @inheritDoc
	 */
	protected function loadRepository(): array
	{
		$repos = [];

		$generator = $this->yieldFiles();

		$patterns = [];
		foreach($this->getLoaders() as $loader) {
			if($loader instanceof FileLoaderPreFilterInterface) {
				$patterns = array_merge($patterns, $loader->getFilters());
			}
		}
		if($patterns)
			$generator = RealPathTool::applyFilters($generator, $patterns);

		foreach($generator as $file) {
			$path = $file->getPathname();
			if($loader = $this->getLoader($path)) {
				$theme = $loader->getTheme($file);
				if($theme) {
					$repos[ $theme->getIdentifier() ] = $theme;
				}
			}
		}

		return $repos;
	}
}