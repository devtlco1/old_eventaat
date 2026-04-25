<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use App\Http\Resources\Admin\StoryResource;
use App\Models\Story;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoriesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('story_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StoryResource(Story::with(['restaurant', 'team'])->get());
    }

    public function store(StoreStoryRequest $request)
    {
        $story = Story::create($request->all());

        if ($request->input('file', false)) {
            $story->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new StoryResource($story))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Story $story)
    {
        abort_if(Gate::denies('story_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StoryResource($story->load(['restaurant', 'team']));
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        $story->update($request->all());

        if ($request->input('file', false)) {
            if (! $story->file || $request->input('file') !== $story->file->file_name) {
                if ($story->file) {
                    $story->file->delete();
                }
                $story->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($story->file) {
            $story->file->delete();
        }

        return (new StoryResource($story))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Story $story)
    {
        abort_if(Gate::denies('story_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $story->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
