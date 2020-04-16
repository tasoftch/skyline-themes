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

/**
 * HashGeneratorTest.php
 * skyline-themes
 *
 * Created on 16.04.20 11:22 by thomas
 */

use PHPUnit\Framework\TestCase;
use Skyline\Themes\Hash\HashFileContentGenerator;

class HashGeneratorTest extends TestCase
{
	public function testMD5Hash() {
		$gen = new HashFileContentGenerator( HashFileContentGenerator::ALGO_MD5 );
		$this->assertEquals(hash_file('md5', "LICENSE"), $gen->generateFileHash("LICENSE"));
	}

	public function testSHA1() {
		$gen = new HashFileContentGenerator( HashFileContentGenerator::ALGO_SHA_1 );
		$this->assertEquals(hash_file('sha1', "LICENSE"), $gen->generateFileHash("LICENSE"));
	}

	public function testSHA384() {
		$gen = new HashFileContentGenerator( HashFileContentGenerator::ALGO_SHA_384 );
		$this->assertEquals(hash_file('sha384', "LICENSE"), $gen->generateFileHash("LICENSE"));
	}
}
