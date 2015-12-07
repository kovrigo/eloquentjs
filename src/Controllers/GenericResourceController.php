<?php

namespace EloquentJs\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GenericResourceController extends Controller
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Set the model for this resource controller.
     *
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model->useEloquentJs()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Model
     */
    public function store(Request $request)
    {
        return $this->model->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id === '*') {
            return $this->model->newQuery()->useEloquentJs()->update($request->all());
        }

        $resource = $this->model->findOrFail($id);

        $resource->update($request->all());

        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === '*') {
            return $this->model->newQuery()->useEloquentJs()->delete();
        }

        $resource = $this->model->findOrFail($id);

        return ['success' => $resource->delete()];
    }
}
