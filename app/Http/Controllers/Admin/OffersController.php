<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOfferRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Event;
use App\Models\Offer;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OffersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('offer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offers = Offer::with(['restaurant', 'team'])->get();

        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        abort_if(Gate::denies('offer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.offers.create', compact('restaurants'));
    }

    public function store(StoreOfferRequest $request)
    {
        $validation = $request->validate([
            'restaurant_id' => ['required', 'exists:restaurents,id'],
            'title' => ['required', 'string', 'max:255'],
            'starting_at' => ['required', 'date', 'before_or_equal:ending_at'],
            'ending_at' => ['required', 'date', 'after_or_equal:starting_at'],
            'disception' => ['required', 'string'],
            // 'images.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'approved' => ['boolean'],
        ]);
        $offer = Offer::create($request->all());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $offer->addMedia($file->store('tmp/uploads'))->toMediaCollection('offer_images');
            }
        }
        if(isset($_GET["id"])) return redirect()->route('admin.restaurents.show', $_GET["id"]);

        return redirect()->route('admin.offers.index');
    }

    public function edit(Offer $offer)
    {
        abort_if(Gate::denies('offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $offer->load('restaurant', 'team');

        return view('admin.offers.edit', compact('offer', 'restaurants'));
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $validation = $request->validate([
            'restaurant_id' => ['required', 'exists:restaurents,id'],
            'title' => ['required', 'string', 'max:255'],
            'starting_at' => ['required', 'date', 'before_or_equal:ending_at'],
            'ending_at' => ['required', 'date', 'after_or_equal:starting_at'],
            'disception' => ['required', 'string'],
            // 'images.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'approved' => ['boolean'],
        ]);
        $offer->update($request->all());

        if (count($offer->images) > 0) {
            foreach ($offer->images as $media) {
                if (! in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $offer->images->pluck('file_name')->toArray();
        foreach ($request->file('images', []) as $file) {
            if (count($media) === 0 || ! in_array($file->getClientOriginalName(), $media)) {
                $offer->addMedia($file->store('tmp/uploads'))->toMediaCollection('offer_images');
            }
        }

        return redirect()->route('admin.offers.index');
    }

    public function show(Offer $offer)
    {
        abort_if(Gate::denies('offer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offer->load('restaurant', 'team');

        return view('admin.offers.show', compact('offer'));
    }

    public function destroy(Offer $offer)
    {
        abort_if(Gate::denies('offer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offer->delete();

        return back();
    }

    public function massDestroy(MassDestroyOfferRequest $request)
    {
        $offers = Offer::find(request('ids'));

        foreach ($offers as $offer) {
            $offer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function approve($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->update([
            'approved' => 1
        ]);
        return redirect()->back();
    }

    public function toggleApproval(Request $request)
    {
        $offer = Offer::findOrFail($request->id);
        $offer->approved = !$offer->approved;
        $offer->save();
        return response()->json(['success' => true], 200, ['Content-Type' => 'application/json']);

    }

}
