<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRestaurentRequest;
use App\Http\Requests\StoreRestaurentRequest;
use App\Http\Requests\UpdateRestaurentRequest;
use App\Models\City;
use App\Models\Restaurant;
use App\Models\Team;
use App\Models\User;
use App\Models\KitchenType;
use App\Models\Contact;
use App\Models\Feature;
use App\Models\Privacy;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RestaurentsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('restaurent_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurents = Restaurant::with(['city', 'team', 'media'])->get();

        return view('admin.restaurents.index' , compact('restaurents'));
    }

    public function create()
    {
        abort_if(Gate::denies('restaurent_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurants = Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $features = Feature::all();
        $kitchen_types = KitchenType::all();
        $privacies = Privacy::all();
        return view('admin.restaurents.create', compact('restaurants','cities','features','kitchen_types','privacies'));
    }

    public function store(StoreRestaurentRequest $request)
    {
        $validation = $request->validate([
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
            ],
            'mobile' => [
                'string',
                'required',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'website_url' => [
                'string',
                'nullable',
            ],
            'menu_url' => [
                'string',
                'nullable',
            ],
            'location_url' => [
                'string',
                'nullable',
            ],
            'images' => [
                'array',
            ],
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> 'password',
            'active'=>1,
            'team_id'=>$request->team_id,
            'mobile'=>$request->phone,
        ]);
        $request['user_id'] = $user->id;
        $restaurent = Restaurant::create($request->all());
        Contact::create([
            'restaurant_id' => $restaurent->id,
            'position' => $user->name,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->country_code . $user->mobile
        ]);
        $features = $request->input('features', []); 
        $features = array_map('intval', $features);
        $kitchen_types = $request->input('kitchen_types', []);
        $kitchen_types = array_map('intval', $kitchen_types);
        $privacies = $request->input('privacies', []);
        $privacies = array_map('intval', $privacies);
        $restaurent->update([
            'features_id' => $features,
            'kitchen_types_id' => $kitchen_types,
            'privacies_id' => $privacies,
        ]);
        $user->roles()->sync([1]);

        if ($request->input('logo', false)) {
            $restaurent->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($request->input('menu_image', false)) {
            $restaurent->addMedia(storage_path('tmp/uploads/' . basename($request->input('menu_image'))))->toMediaCollection('menu_image');
        }

        foreach ($request->input('images', []) as $file) {
            $restaurent->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $restaurent->id]);
        }

        return redirect()->route('admin.restaurents.index');
    }

    public function edit(Restaurant $restaurent)
    {
        abort_if(Gate::denies('restaurent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurent->load('team');
        $restaurants = Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.restaurents.edit', compact('restaurent','restaurants','cities'));
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

        if ($request->input('menu_image', false)) {
            if (! $restaurent->menu_image || $request->input('menu_image') !== $restaurent->menu_image->file_name) {
                if ($restaurent->menu_image) {
                    $restaurent->menu_image->delete();
                }
                $restaurent->addMedia(storage_path('tmp/uploads/' . basename($request->input('menu_image'))))->toMediaCollection('menu_image');
            }
        } elseif ($restaurent->menu_image) {
            $restaurent->menu_image->delete();
        }

        return redirect()->route('admin.restaurents.index');
    }

    public function show(Restaurant $restaurent)
    {
        abort_if(Gate::denies('restaurent_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurent->load('city', 'team', 'restaurantEvents', 'restaurantStories', 'restaurantOffers', 'restaurantContacts');

        return view('admin.restaurents.show', compact('restaurent'));
    }

    public function destroy(Restaurant $restaurent)
    {
        abort_if(Gate::denies('restaurent_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurent->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurentRequest $request)
    {
        $restaurents = Restaurant::find(request('ids'));

        foreach ($restaurents as $restaurent) {
            $restaurent->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('restaurent_create') && Gate::denies('restaurent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Restaurant();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function getWebsiteUrl($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return response()->json(['website_url' => $restaurant->website_url]);
    }
}
