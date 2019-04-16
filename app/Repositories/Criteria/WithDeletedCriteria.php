<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithDeletedCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class WithDeletedCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (method_exists($model, 'trashed') ||
            method_exists($model, 'withTrashed')
        ) {
            $model = $model->withTrashed();
        }

        return $model;
    }
}
