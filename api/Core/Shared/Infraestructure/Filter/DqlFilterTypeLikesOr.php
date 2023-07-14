<?php

declare(strict_types=1);

namespace Core\\Shared\Infraestructure\Filter;

use Doctrine\ORM\QueryBuilder;
use Core\\Shared\Domain\Filter\Filter;

final class DqlFilterTypeLikesOr implements DqlFilterType
{
    public function apply(Filter $filter, string $alias, QueryBuilder $queryBuilder): void
    {
        $dql       = '(';
        $separator = '';

        $filterValues = $filter->value->value;
        if (is_string($filterValues)) {
            $filterValues = [$filterValues];
        }
        $filterFields = $filter->field->field;
        if (is_string($filterFields)) {
            $filterFields = [$filterFields];
        }

        $index = 1;
        foreach ($filterFields as $aFieldField) {
            foreach ($filterValues as $aFieldValue) {
                $dql       = $dql . $separator . ' ' . $alias . '.' . $aFieldField . ' LIKE :a_value_' . $index;
                $separator = ' OR ';

                $index = $index + 1;
            }
        }

        $dql = $dql . ')';
        $queryBuilder->andWhere($dql);

        $index = 1;
        foreach ($filterFields as $aFieldField) {
            foreach ($filterValues as $aFieldValue) {
                $queryBuilder->setParameter('a_value_' . $index, '%' . $aFieldValue . '%');

                $index = $index + 1;
            }
        }
    }
}
