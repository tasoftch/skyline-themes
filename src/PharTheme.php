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

namespace Skyline\Themes;


use Skyline\Themes\Meta\DynamicMeta;

class PharTheme extends AbstractFileTheme
{
	const SIZES_FILE_KEY = 'sizes';
	const HASHES_FILE_KEY = 'hashes';

	private $phar;

	/**
	 * @inheritDoc
	 */
	protected function loadFile($filename): bool
	{
		$info = require $filename;
		if(is_array($info) || $info instanceof \ArrayAccess) {
			$this->phar = new \Phar($filename);

			$md = new DynamicMeta();
			if(is_array($sizes = $info[self::SIZES_FILE_KEY] ?? NULL)) {
				$md->setFileSizes($sizes);
			}
			if(is_array($hashes = $info[self::HASHES_FILE_KEY] ?? NULL)) {
				$md->setFileHashes($hashes);
			}

			$this->meta = $md;
			return true;
		}
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function extractFile(string $fileID, string $destination): bool
	{
		// TODO: Implement extractFile() method.
	}
}