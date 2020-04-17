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


use Skyline\Themes\Repository\Loader\LoaderInterface;
use Skyline\Themes\Theme\ThemeInterface;

abstract class AbstractRepository implements RepositoryInterface
{
	private $themes;

	/** @var LoaderInterface[] */
	protected $loaders;

	/**
	 * @inheritDoc
	 */
	public function getThemes()
	{
		if(!$this->themes)
			$this->themes = $this->loadRepository();
		return $this->themes;
	}

	/**
	 * @return LoaderInterface[]
	 */
	public function getLoaders(): array
	{
		return $this->loaders;
	}

	/**
	 * Adds a new loader to the repository
	 *
	 * @param LoaderInterface $loader
	 * @return static
	 */
	public function addLoader(LoaderInterface $loader) {
		if(!in_array($loader, $this->loaders))
			$this->loaders[] = $loader;
		return $this;
	}

	/**
	 * Removes a loader
	 *
	 * @param LoaderInterface $loader
	 * @return static
	 */
	public function removeLoader(LoaderInterface $loader) {
		if(($idx = array_search($loader, $this->loaders)) !== false)
			unset($this->loaders[$idx]);
		return $this;
	}

	/**
	 * Sets a bunch of loaders
	 * @param LoaderInterface[] $loaders
	 * @return static
	 */
	public function setLoaders(array $loaders) {
		$this->loaders = $loaders;
		return $this;
	}

	/**
	 * Loads the repo
	 *
	 * @return ThemeInterface[]
	 */
	abstract protected function loadRepository(): array;
}