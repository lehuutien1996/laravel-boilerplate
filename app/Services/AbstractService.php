<?php

namespace App\Services;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria\OnlyDeletedCriteria;
use App\Repositories\Criteria\WithDeletedCriteria;
use App\Services\Concerns\HasAttributeModification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Prettus\Validator\AbstractValidator;

abstract class AbstractService
{
    use HasAttributeModification;

    /**
     * @var RepositoryInterface
     */
    protected $repository = null;

    /**
     * @var AbstractValidator
     */
    protected $createValidator = null;

    /**
     * @var AbstractValidator
     */
    protected $updateValidator = null;

    /**
     * @param array $attributes
     * @param \Closure $callback
     * @return Model
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $attributes, \Closure $callback = null)
    {
        if (!is_null($this->createValidator)) {
            $this->createValidator->with($attributes)->passesOrFail();
        }

        $attributes = $callback($attributes) ?? $this->beforeCreate($attributes);

        return $this->repository->create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @param \Closure|null $callback
     * @return Model
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, array $attributes, \Closure $callback = null)
    {
        if (!is_null($this->updateValidator)) {
            $this->updateValidator->with($attributes)->passesOrFail();
        }

        $attributes = $callback($attributes) ?? $this->beforeUpdate($attributes);

        return $this->repository->update($attributes, $id);
    }

    /**
     * @param array $options
     * @return Collection
     */
    public function all(array $options = [])
    {
        $columns = $options['columns'] ?? ['*'];

        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortDir = $options['sort_dir'] ?? 'desc';

        $this->repository->orderBy($sortBy, $sortDir);
        $this->repository->orderBy('updated_at', 'desc');

        if (isset($options['with_deleted'])) {
            $this->repository->pushCriteria(new WithDeletedCriteria);
        }

        if (isset($options['only_deleted'])) {
            $this->repository->pushCriteria(new OnlyDeletedCriteria);
        }

        return $this->repository->all($columns);
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function paginate(array $options = [])
    {
        $limit   = $options['limit'] ?? null;
        $columns = $options['columns'] ?? ['*'];

        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortDir = $options['sort_dir'] ?? 'desc';

        $this->repository->orderBy($sortBy, $sortDir);
        $this->repository->orderBy('updated_at', 'desc');

        if (isset($options['with_deleted'])) {
            $this->repository->pushCriteria(new WithDeletedCriteria);
        }

        if (isset($options['only_deleted'])) {
            $this->repository->pushCriteria(new OnlyDeletedCriteria);
        }

        return $this->repository->paginate($limit, $columns);
    }
}
