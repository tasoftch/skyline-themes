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
 * MetaTest.php
 * skyline-themes
 *
 * Created on 16.04.20 11:55 by thomas
 */

use PHPUnit\Framework\TestCase;
use Skyline\Themes\Meta\DynamicMeta;
use Skyline\Themes\Meta\StaticMeta;

class MetaTest extends TestCase
{
	public function testStaticMeta() {
		$meta = new StaticMeta();

		$this->assertEmpty($meta->getFileIdentifiers());
	}

	public function testStaticSingleSize() {
		$meta = new StaticMeta([
			'my-file' => 53
		]);

		$this->assertCount(1, $meta->getFileIdentifiers());;
		$this->assertEquals(53, $meta->getSize('my-file'));
		$this->assertSame(0, $meta->getSize('unexisting'));
	}

	public function testStaticSingleHash() {
		$meta = new StaticMeta([], [
			'my-file' => 'hash'
		]);

		$this->assertCount(1, $meta->getFileIdentifiers());;
		$this->assertEquals('hash', $meta->getHash('my-file'));
		$this->assertSame('', $meta->getHash('unexisting'));
	}

	public function testStaticUniquely() {
		$meta = new StaticMeta([
			'my-file' => 53
		], [
			'my-file' => 'hash'
		]);

		$this->assertCount(1, $meta->getFileIdentifiers());;
		$this->assertEquals(53, $meta->getSize('my-file'));
		$this->assertSame(0, $meta->getSize('unexisting'));
		$this->assertEquals('hash', $meta->getHash('my-file'));
		$this->assertSame('', $meta->getHash('unexisting'));
	}

	public function testDynamicalAddNonexistent() {
		$meta = new DynamicMeta([
			'my-file' => 53
		], [
			'my-file' => 'hash'
		]);

		$meta->addFileSize('test.txt', 44);

		$this->assertCount(2, $meta->getFileIdentifiers());;
		$this->assertEquals(53, $meta->getSize('my-file'));
		$this->assertSame(44, $meta->getSize('test.txt'));
	}

	public function testDynamicalAddExistent() {
		$meta = new DynamicMeta([
			'my-file' => 53
		], [
			'my-file' => 'hash'
		]);

		$meta->addFileSize('my-file', 44);

		$this->assertCount(1, $meta->getFileIdentifiers());;
		$this->assertEquals(44, $meta->getSize('my-file'));
		$this->assertSame(0, $meta->getSize('test.txt'));
	}

	public function testDynamicSetFileSizes() {
		$meta = new DynamicMeta([
			'my-file' => 53
		], [
			'my-file' => 'hash'
		]);

		$meta->addFileSize('my-file', 44);

		$meta->setFileSizes([
			'my-file' => 30,
			'test.txt' => 19
		]);

		$this->assertCount(2, $meta->getFileIdentifiers());;
		$this->assertEquals(30, $meta->getSize('my-file'));
		$this->assertSame(19, $meta->getSize('test.txt'));
	}

	public function testDynamicRemoveFileSize() {
		$meta = new DynamicMeta([
			'my-file' => 53
		], [
			'my-file' => 'hash'
		]);

		$meta->addFileSize('my-file', 44);

		$meta->setFileSizes([
			'my-file' => 30,
			'test.txt' => 19
		]);

		$meta->removeFileSize('my-file');

		// Because my-file is used as hash as well
		$this->assertCount(2, $meta->getFileIdentifiers());
		$this->assertEquals(0, $meta->getSize('my-file'));
		$this->assertSame(19, $meta->getSize('test.txt'));
	}
}
