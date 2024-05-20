<?php

namespace App\Concerns;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ReflectionException;

trait HasCrud
{
    /**
     * @throws ReflectionException
     */
    public function index(Request $request): JsonResponse
    {
        $params = $request->all();
        $model = $this->model::query();

        if (!empty($params['filter']))
            $model = $this->filterModel($params['filter'], $model);

        if (!empty($params['top']))
            $model = $model->take((int)$params['top']);

        if (!empty($params['orderby'])){
            $orderBy = explode(',', $params['orderby']);
            $this->orderByDirection = array_pop($orderBy);
            $this->orderByColumn = array_shift($orderBy);
        }

        $model = $this->getRelatedModels($model, $params);

        $model->orderBy($this->orderByColumn, $this->orderByDirection);

        return $this->respond($model->get());
    }

    public function store(Request $request): JsonResponse
    {
        $model = new $this->model();
        $data = $request->all();
        $model->fill($data);
        $model->save();

        if ($this->hasFiles($request))
            $this->saveFiles($model, $request->allFiles());

        return $this->respond($model->fresh());
    }

    public function show(Request $request, $id): JsonResponse
    {
        $params = $request->all();
        $model = $this->model::query();

        if (!empty($params['filter']))
            $model = $this->filterModel($params['filter'], $model);

        $model = $this->getRelatedModels($model, $params);

        $model->orderBy($this->orderByColumn, $this->orderByDirection);

        $model = $model->whereId($id)->first();

        if (!$model)
            return $this->respond(new Exception('Record not found'));

        return $this->respond($model);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $model = $this->model::find($id);

        if (!$model)
            return $this->respond(new Exception('Record not found'));

        $model->fill($request->all());
        $model->save();

        if ($this->hasFiles($request))
            $this->saveFiles($model, $request->allFiles());

        return $this->respond($model->fresh());
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $model = $this->model::find($id);

        if (!$model)
            return $this->respond(new Exception('Record not found'));

        $model->delete();

        return $this->respond($this->model.' deleted');
    }

    public function forceDestroy(Request $request, $id): JsonResponse
    {
        $model = $this->model::find($id);

        if (!$model)
            return $this->respond(new Exception('Record not found'));

        $model->forceDelete();

        return $this->respond($this->model.' deleted');
    }
}
