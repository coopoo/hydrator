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

namespace HydratorBenchmark\Filter;

use Athletic\AthleticEvent;
use Hydrator\Context\ExtractionContext;
use Hydrator\Filter\CompositeFilter;
use Hydrator\Filter\FilterChain;
use Hydrator\Filter\HasFilter;
use Hydrator\Filter\IsFilter;
use Hydrator\Filter\GetFilter;
use Hydrator\Filter\OptionalParametersFilter;
use HydratorBenchmark\Asset\CompositeFilterObject;

class CompositeFilterBenchmark extends AthleticEvent
{
    /**
     * @var FilterChain
     */
    protected $filter;

    /**
     * @var CompositeFilterObject
     */
    protected $object;

    public function classSetUp()
    {
        $this->filter = new FilterChain();

        $this->filter->andFilter(new CompositeFilter(
            [new GetFilter(), new HasFilter(), new IsFilter()],
            CompositeFilter::TYPE_OR
        ));
        $this->filter->andFilter(new OptionalParametersFilter());

        $this->object = new CompositeFilterObject();
    }

    /**
     * @iterations 1000
     */
    public function traverseCompositeFilter()
    {
        $context         = new ExtractionContext();
        $context->object = $this->object;

        $this->filter->accept('getOne', $context);
        $this->filter->accept('getTwo', $context);
        $this->filter->accept('isThree', $context);
    }
}
