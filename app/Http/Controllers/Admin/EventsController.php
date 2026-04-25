<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\Feature;
use App\Models\Privacy;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EventsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::with(['restaurant', 'privacy', 'features', 'team', 'media'])->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $privacies = Privacy::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $features = Feature::pluck('title', 'id');

        return view('admin.events.create', compact('features', 'privacies', 'restaurants'));
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->all());
        $event->features()->sync($request->input('features', []));
        foreach ($request->input('images', []) as $file) {
            $event->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $event->id]);
        }

        if(isset($_GET["id"])) return redirect()->route('admin.restaurents.show', $_GET["id"]);
        return redirect()->route('admin.events.index');
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'approved' => 1
        ]);
        return redirect()->back();
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $privacies = Privacy::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $features = Feature::pluck('title', 'id');

        $event->load('restaurant', 'privacy', 'features', 'team');

        return view('admin.events.edit', compact('event', 'features', 'privacies', 'restaurants'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());
        $event->features()->sync($request->input('features', []));
        if (count($event->images) > 0) {
            foreach ($event->images as $media) {
                if (! in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $event->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $event->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.events.index');
    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->load('restaurant', 'privacy', 'features', 'team', 'eventBookings');

        return view('admin.events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventRequest $request)
    {
        $events = Event::find(request('ids'));

        foreach ($events as $event) {
            $event->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('event_create') && Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Event();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function toggleApproval(Request $request)
    {
        $offer = Event::findOrFail($request->id);
        $offer->approved = !$offer->approved;
        $offer->save();
        return response()->json(['success' => true], 200, ['Content-Type' => 'application/json']);

    }
}
