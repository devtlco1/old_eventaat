<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRestaurentRequest;
use App\Http\Requests\UpdateRestaurentRequest;
use App\Http\Resources\Admin\RestaurentResource;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurentsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('restaurent_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurentResource(Restaurant::with(['team'])->get());
    }

    public function store(StoreRestaurentRequest $request)
    {
        $restaurent = Restaurant::create($request->all());

        if ($request->input('logo', false)) {
            $restaurent->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        foreach ($request->input('images', []) as $file) {
            $restaurent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        return (new RestaurentResource($restaurent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Restaurant $restaurent)
    {
        abort_if(Gate::denies('restaurent_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurentResource($restaurent->load(['team']));
    }

    public function update(UpdateRestaurentRequest $request, Restaurant $restaurent)
    {
        $restaurent->update($request->all());

        if ($request->input('logo', false)) {
            if (! $restaurent->logo || $request->input('logo') !== $restaurent->logo->file_name) {
                if ($restaurent->logo) {
                    $restaurent->logo->delete();
                }
                $restaurent->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($restaurent->logo) {
            $restaurent->logo->delete();
        }

        if (count($restaurent->images) > 0) {
            foreach ($restaurent->images as $media) {
                if (! in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $restaurent->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $restaurent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return (new RestaurentResource($restaurent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Restaurant $restaurent)
    {
        abort_if(Gate::denies('restaurent_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
