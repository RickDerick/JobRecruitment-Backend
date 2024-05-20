<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use ReflectionClass;
use ReflectionException;

trait HasRelations
{
    /**
     * @throws ReflectionException
     */
    public function getRelations($model): array
    {
        $reflector = new ReflectionClass($model);

        $relationships = [];

        foreach($reflector->getMethods() as $method){
            $returnType = $method->getReturnType();

            if ($returnType)
                switch (class_basename($returnType->getName())){
                    case 'HasOne':
                    case 'HasMany';
                    case 'HasManyThrough';
                    case 'BelongsTo';
                    case 'BelongsToMany';
                        $relationships[] = $method->getName();

                }
        }

        return $relationships;
    }

    /**
     * @throws ReflectionException
     */
    public function getRelatedModels(Builder $model, array $params): Builder
    {
        $relations = $this->getRelations($this->model);

        if (empty($params['expand']))
            return $model;

        if ($params['expand'] === '*')
            $model->with($relations);

        foreach (explode(',', $params['expand']) as $item){
            if (in_array($item, $relations))
                $model->with($item);
        }

        return $model;
    }

    public function filterModel(string $filter, Builder $model): Builder
    {
        $filters = rtrim(ltrim($filter, '('), ')');
        $filters = explode(',', $filters );

        $filter = [];
        foreach ($filters as $item){
            $f = explode('=', $item);
            $filter[trim(array_shift($f))] = trim(array_pop($f));
        }

        return $model->where($filter);
    }
}
