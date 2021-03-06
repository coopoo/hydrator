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

namespace Hydrator\Filter;

use Hydrator\Context\ExtractionContext;

/**
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 * @licence MIT
 */
class FilterChain implements FilterInterface
{
    /**
     * @var FilterInterface|null
     */
    protected $filter;

    /**
     * @param  FilterInterface $filter
     * @return void
     */
    public function andFilter(FilterInterface $filter)
    {
        if (null === $this->filter) {
            $this->filter = $filter;
        }

        $this->filter = new CompositeFilter([$this->filter, $filter], CompositeFilter::TYPE_AND);
    }

    /**
     * @param  FilterInterface $filter
     * @return void
     */
    public function orFilter(FilterInterface $filter)
    {
        if (null === $this->filter) {
            $this->filter = $filter;
        }

        $this->filter = new CompositeFilter([$this->filter, $filter], CompositeFilter::TYPE_OR);
    }

    /**
     * {@inheritDoc}
     */
    public function accept($property, ExtractionContext $context = null)
    {
        if (null === $this->filter) {
            return true;
        }

        return $this->filter->accept($property, $context);
    }
}
