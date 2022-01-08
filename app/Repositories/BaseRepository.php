<?php

namespace App\Repositories;

use App\Http\Criterias\CriteriaInterface;
use App\Repositories\RepositoryInterface;
use App\Http\Presenters\PresenterInterface;
use Illuminate\Http\Request;

class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $query;
    protected $presenter;
    protected $modelInstance;
    
    public function __construct(string $model)
    {
        $this->reinit($model);
    }

    public function reinit(string $model)
    {
        $this->model = $model;
        $this->modelInstance = null;
        $this->query = null;
        $this->total = 0;
    }

    public function getModel()
    {
        if (!$this->modelInstance) {
            $this->modelInstance = app()->make($this->model);
        }

        return $this->modelInstance;
    }

    public function applyCriteria(CriteriaInterface $criteria)
    {
        $this->query = $criteria->apply($this->query);

        return $this;
    }

    public function setPresenter(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }

    public function auth()
    {
        \Auth::user() ? \Auth::user()->id : Request::all()->id; 
    }
}
