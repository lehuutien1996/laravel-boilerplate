<?php

namespace App\Repositories\Eloquents;

use Prettus\Validator\Contracts\ValidatorInterface;

abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
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
    public function firstOrCreateWhere(array $where, array $attributes = null, ValidatorInterface $validator = null)
    {
        $instance = $this->findWhere($where)->first();

        if (empty($instance)) {
            $attributes = $attributes ?: $where;

            // Validate if {$validator} parameter is not null
            if (!is_null($validator)) {
                $validator->with($attributes)->passesOrFail();
            }

            $instance = $this->create($attributes);
        }

        return $instance;
    }
}
