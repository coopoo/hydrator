<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace HydratorTest\Filter;

use Hydrator\Filter\ExcludeMethodsFilter;

class ExcludeMethodsFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterWithOneMethod()
    {
        $filter = new ExcludeMethodsFilter(['getPassword']);

        $this->assertTrue($filter->accept('getName'));
        $this->assertTrue($filter->accept('Object::getName'));
        $this->assertFalse($filter->accept('getPassword'));
        $this->assertFalse($filter->accept('Object::getPassword'));
    }

    public function testFilterWithMultipleMethod()
    {
        $filter = new ExcludeMethodsFilter(['getPassword', 'getToken']);

        $this->assertTrue($filter->accept('getName'));
        $this->assertTrue($filter->accept('Object::getName'));
        $this->assertFalse($filter->accept('getPassword'));
        $this->assertFalse($filter->accept('Object::getPassword'));
        $this->assertFalse($filter->accept('getToken'));
        $this->assertFalse($filter->accept('Object::getToken'));
    }
}
