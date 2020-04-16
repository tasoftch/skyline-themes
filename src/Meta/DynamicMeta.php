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

namespace Skyline\Themes\Meta;


class DynamicMeta extends StaticMeta
{
	/**
	 * @param array $fileSizes
	 * @return DynamicMeta
	 */
	public function setFileSizes(array $fileSizes): DynamicMeta
	{
		$this->fileSizes = $fileSizes;
		$this->fileIdentifiers = array_unique( array_merge( array_keys($fileSizes), array_keys($this->fileHashes) ) );
		return $this;
	}

	/**
	 * @param string $fileID
	 * @param int $size
	 * @return static
	 */
	public function addFileSize(string $fileID, int $size) {
		if(!isset($this->fileSizes[$fileID]))
			$this->fileIdentifiers[] = $fileID;
		$this->fileSizes[$fileID] = $size;
		return $this;
	}

	/**
	 *
	 *
	 * @param string $fileID
	 * @return static
	 */
	public function removeFileSize(string $fileID) {
		unset($this->fileSizes[$fileID]);
		if(!isset($this->fileHashes[$fileID])) {
			$idx = array_search($fileID, $this->fileIdentifiers);
			unset($this->fileIdentifiers[$idx]);
		}
		return $this;
	}

	/**
	 * @param array $fileHashes
	 * @return static
	 */
	public function setFileHashes(array $fileHashes): DynamicMeta
	{
		$this->fileHashes = $fileHashes;
		$this->fileIdentifiers = array_unique( array_merge( array_keys($this->fileSizes), array_keys($fileHashes) ) );
		return $this;
	}

	/**
	 * @param string $fileID
	 * @param string $hash
	 * @return static
	 */
	public function addFileHash(string $fileID, string $hash) {
		if(!isset($this->fileHashes[$fileID]))
			$this->fileIdentifiers[] = $fileID;
		$this->fileHashes[$fileID] = $hash;
		return $this;
	}

	/**
	 *
	 *
	 * @param string $fileID
	 * @return static
	 */
	public function removeFileHash(string $fileID) {
		unset($this->fileHashes[$fileID]);
		if(!isset($this->fileSizes[$fileID])) {
			$idx = array_search($fileID, $this->fileIdentifiers);
			unset($this->fileIdentifiers[$idx]);
		}
		return $this;
	}
}