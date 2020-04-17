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


use Skyline\Themes\Theme\ThemeInterface;
use TASoft\Service\ServiceInterface;

interface ThemeServiceInterface extends ServiceInterface
{
	/**
	 * Must return a working directory where the themes should be applied
	 *
	 * @return string
	 */
	public function getWorkingDirectory(): string;

	/**
	 * If set, does not allow to modify files outside of the working directory
	 *
	 * @return bool
	 */
	public function restrictToWorkingDirectoryOnly(): bool;


	/**
	 * Gets all physical present themes ready to install
	 *
	 * @return string[]
	 */
	public function getAvailableThemeIdentifiers();

	/**
	 * Gets a list of all installed theme identifiers
	 *
	 * @return string[]
	 */
	public function getInstalledThemeIdentifiers();

	/**
	 * Searches for all identifiers of themes which match a given name.
	 * The name may contain glob patterns.
	 *
	 * @param string $name
	 * @return array
	 */
	public function getIdentifiersForName(string $name): array;

	/**
	 * This really loads a theme from physical into memory and prepares it to install or uninstall.
	 *
	 * @param string $identifier
	 * @return ThemeInterface|null
	 */
	public function prepareTheme(string $identifier):?ThemeInterface;

	/**
	 * Memory intensive themes can release memory on this call.
	 *
	 * @param ThemeInterface $theme
	 * @return bool
	 */
	public function releaseTheme(ThemeInterface $theme): bool;

	/**
	 * This method installs a prepared theme into the current working directory.
	 *
	 * @param ThemeInterface $theme
	 * @return void
	 */
	public function installTheme(ThemeInterface $theme);

	/**
	 * This method removes a theme from the current working directory
	 *
	 * @param ThemeInterface $theme
	 * @return void
	 */
	public function uninstallTheme(ThemeInterface $theme);
}