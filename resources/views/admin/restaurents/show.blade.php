@extends('layouts.admin')
@section('content')


<div class="card">
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#details" role="tab" data-toggle="tab">
                {{ trans('cruds.restaurent.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#restaurant_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#restaurant_stories" role="tab" data-toggle="tab">
                {{ trans('cruds.story.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#restaurant_offers" role="tab" data-toggle="tab">
                {{ trans('cruds.offer.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#restaurant_contacts" role="tab" data-toggle="tab">
                {{ trans('cruds.contact.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane show active sections" role="tabpanel" id="details">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.id') }}
                                </th>
                                <td>
                                    {{ $restaurent->id }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.name') }}
                                </th>
                                <td>
                                    {{ $restaurent->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.mobile') }}
                                </th>
                                <td>
                                    {{ $restaurent->mobile }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.address') }}
                                </th>
                                <td>
                                    {{ $restaurent->address }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.website_url') }}
                                </th>
                                <td>
                                    {{ $restaurent->website_url }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.menu_url') }}
                                </th>
                                <td>
                                    {{ $restaurent->menu_url }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.location_url') }}
                                </th>
                                <td>
                                    {{ $restaurent->location_url }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.logo') }}
                                </th>
                                <td>
                                    @if($restaurent->logo)
                                        <a href="{{ $restaurent->logo->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $restaurent->logo->getUrl('thumb') }}">
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {{ trans('cruds.restaurent.fields.images') }}
                                </th>
                                <td>
                                    @foreach($restaurent->images as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $media->getUrl('thumb') }}">
                                        </a>
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" role="tabpanel" id="restaurant_events">
            @includeIf('admin.restaurents.relationships.restaurantEvents', ['events' => $restaurent->restaurantEvents])
        </div>
        <div class="tab-pane" role="tabpanel" id="restaurant_stories">
            @includeIf('admin.restaurents.relationships.restaurantStories', ['stories' => $restaurent->restaurantStories])
        </div>
        <div class="tab-pane" role="tabpanel" id="restaurant_offers">
            @includeIf('admin.restaurents.relationships.restaurantOffers', ['offers' => $restaurent->restaurantOffers])
        </div>
        <div class="tab-pane" role="tabpanel" id="restaurant_contacts">
            @includeIf('admin.restaurents.relationships.restaurantContacts', ['contacts' => $restaurent->restaurantContacts])
        </div>
    </div>
</div>

@endsection
