<?php

namespace App\Services\Concerns;

trait HasAttributeModification
{
    /**
     * Take before create action
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function beforeCreate(array $attributes)
    {
        return $attributes;
    }

    /**
     * Take before update action
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function beforeUpdate(array $attributes)
    {
        return $attributes;
    }
}
