<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface as BaseRepositoryInterface;
use Prettus\Validator\Contracts\ValidatorInterface;

interface RepositoryInterface extends BaseRepositoryInterface, RepositoryCriteriaInterface
{
    /**
     * When there's no instance found by $where, then create new one with $attributes
     * If $attributes doesn't exists create instance with $where
     *
     * @param array              $where      Finding criteria
     * @param array|null         $attributes Attributes for creation
     * @param ValidatorInterface $validator  Validator for validating $attributes
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function firstOrCreateWhere(array $where, array $attributes = null, ValidatorInterface $validator = null);
}
