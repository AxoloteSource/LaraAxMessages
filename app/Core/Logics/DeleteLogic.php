<?php

namespace App\Core\Logics;

use App\Core\Enums\Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class DeleteLogic extends Logic
{
    public function __construct(?Model $model = null)
    {
        if (is_null($model)) {
            return;
        }
        $this->model = $model;
    }

    abstract public function run(Data $input): JsonResponse;

    protected function before(): bool
    {
        return true;
    }

    protected function action(): Logic
    {
        $this->response = $this->makeQuery()->first();
        $this->response->delete();

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }

    protected function makeQuery(): Builder
    {
        if (method_exists($this->model, 'scopeRemove') || method_exists($this->model, 'remove')) {
            return $this->model->remove();
        }

        return $this->model->newQuery()
            ->where('id', $this->input->id);
    }

    protected function response(): JsonResponse
    {
        if (is_null($this->response)) {
            return Response::error(
                message: 'Not Found', status: Http::NotFound
            );
        }

        return Response::success(
            data: $this->withResource(),
            status: Http::NoContent
        );
    }
}
