<?php

namespace App\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class OnlyDeletedCriteria.
 *
 * @package namespace App\Repositories\Criteria;
 */
class OnlyDeletedCriteria implements CriteriaInterface
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
            method_exists($model, 'onlyTrashed')
        ) {
            $model = $model->onlyTrashed();
        }

        return $model;
    }
}
