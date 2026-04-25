<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStoryRequest;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use App\Models\Restaurant;
use App\Models\Story;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class StoriesController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('story_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stories = Story::with(['restaurant', 'team', 'media'])->get();

        return view('admin.stories.index', compact('stories'));
    }

    public function create()
    {
        abort_if(Gate::denies('story_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.stories.create', compact('restaurants'));
    }

    public function store(StoreStoryRequest $request)
    {
        
        $validation = $request->validate([
            'restaurant_id' => ['required', 'exists:restaurents,id'],
            'title' => ['required'],
            
            // 'images.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ]);
    
        $story = Story::create($request->all());

        if ($request->input('file', false) && file_exists(storage_path('tmp/uploads/' . basename($request->input('file'))))) {
            $story->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $story->id]);
        }

        if(isset($_GET["id"])) return redirect()->route('admin.restaurents.show', $_GET["id"]);
        return redirect()->route('admin.stories.index');
    }

    public function edit(Story $story)
    {
        abort_if(Gate::denies('story_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $story->load('restaurant', 'team');

        return view('admin.stories.edit', compact('restaurants', 'story'));
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        $validation = $request->validate([
            'restaurant_id' => ['required', 'exists:restaurents,id'],
            'ad_duration' => ['required', 'integer', 'min:1'],
            // 'images.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
        ]);
        $story->update($request->all());

        if ($request->input('file', false) && file_exists(storage_path('tmp/uploads/' . basename($request->input('file'))))) {
            if (! $story->file || $request->input('file') !== $story->file->file_name) {
                if ($story->file) {
                    $story->file->delete();
                }
                $story->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($story->file) {
            $story->file->delete();
        }

        return redirect()->route('admin.stories.index');
    }

    public function show(Story $story)
    {
        abort_if(Gate::denies('story_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $story->load('restaurant', 'team');

        return view('admin.stories.show', compact('story'));
    }

    public function destroy(Story $story)
    {
        abort_if(Gate::denies('story_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $story->delete();

        return back();
    }

    public function massDestroy(MassDestroyStoryRequest $request)
    {
        $stories = Story::find(request('ids'));

        foreach ($stories as $story) {
            $story->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('story_create') && Gate::denies('story_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Story();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
