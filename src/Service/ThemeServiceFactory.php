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

namespace Skyline\Themes\Service;


use Skyline\Themes\Repository\Loader\DirectoryLoader;
use Skyline\Themes\Repository\Loader\PharLoader;
use Skyline\Themes\Repository\Loader\SkylineCLoader;
use Skyline\Themes\Repository\RecursiveDirectoryRepository;
use TASoft\Service\ConfigurableTrait;
use TASoft\Service\Container\AbstractContainer;

class ThemeServiceFactory extends AbstractContainer
{
	const THEMES_DIRECTORY_NAME = 'directoryName';
	const THEME_LOADERS = 'loaders';

	const PHAR_LOADER = 'PharLoader';
	const SKYLINE_C_LOADER = 'SkylineCLoader';



	use ConfigurableTrait;
	/**
	 * @inheritDoc
	 */
	protected function loadInstance()
	{
		$repo = new RecursiveDirectoryRepository($this->getConfiguration()[ static::THEMES_DIRECTORY_NAME ]);

		foreach(($this->getConfiguration()[static::THEME_LOADERS] ?? []) as $loaderName) {
			$this->addLoaderWithName($loaderName, $repo);
		}

		return $repo->getThemes();
	}

	protected function addLoaderWithName(string $name, RecursiveDirectoryRepository $repo) {
		$method = "addLoaderAs$name";
		if(is_callable([$this, $method]))
			call_user_func([$this, $method], $repo);
	}

	protected function addLoaderAsPharLoader(RecursiveDirectoryRepository $repo) {
		$repo->addLoader(new PharLoader());
	}

	protected function addLoaderAsSkylineCLoader(RecursiveDirectoryRepository $repo) {
		$repo->addLoader(new SkylineCLoader());
	}

	protected function addLoaderAsDirectoryLoader(RecursiveDirectoryRepository $repo) {
		$repo->addLoader(new DirectoryLoader());
	}
}