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

namespace Skyline\Themes\Hash;


use SplFileInfo;

class HashFileContentGenerator extends AbstractGenerator
{
	const ALGO_MD2 = 'md2';
	const ALGO_MD4 = 'md4';
	const ALGO_MD5 = 'md5';

	const ALGO_SHA_1 = 'sha1';
	const ALGO_SHA_224 = 'sha224';
	const ALGO_SHA_256 = 'sha256';
	const ALGO_SHA_384 = 'sha384';

	const ALGO_SHA_512 = 'sha512';
	const ALGO_SHA_512_224 = 'sha512/224';
	const ALGO_SHA_512_256 = 'sha512/256';

	const ALGO_SHA_3_224 = 'sha3-224';
	const ALGO_SHA_3_256 = 'sha3-256';
	const ALGO_SHA_3_384 = 'sha3-384';
	const ALGO_SHA_3_512 = 'sha3-512';

	/** @var string */
	private $algorithm;

	/**
	 * HashFileGenerator constructor.
	 * @param string $algorythmus
	 */
	public function __construct(string $algorithm = self::ALGO_SHA_384)
	{
		$this->algorithm = $algorithm;
	}


	/**
	 * @inheritDoc
	 */
	public function generateFileHash($file): ?string
	{
		if($file instanceof SplFileInfo)
			$file = $file->getRealPath();

		return hash_file($this->getAlgorithm(), $file);
	}

	/**
	 * @return string
	 */
	public function getAlgorithm(): string
	{
		return $this->algorithm;
	}

	/**
	 * Sets the algorithm
	 * For possible values see self::ALG_O*
	 *
	 * @param string $algorithm
	 * @return static
	 * @see HashFileContentGenerator::ALGO_*
	 * @see hash_hmac_algos
	 */
	public function setAlgorithm(string $algorithm)
	{
		$this->algorithm = $algorithm;
		return $this;
	}
}