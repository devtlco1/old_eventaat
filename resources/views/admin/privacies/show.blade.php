@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.privacy.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.privacies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.privacy.fields.id') }}
                        </th>
                        <td>
                            {{ $privacy->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.privacy.fields.title') }}
                        </th>
                        <td>
                            {{ $privacy->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.privacy.fields.titleAR') }}
                        </th>
                        <td>
                            {{ $privacy->title_ar }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.privacies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#privacy_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="privacy_events">
            @includeIf('admin.privacies.relationships.privacyEvents', ['events' => $privacy->privacyEvents])
        </div>
    </div>
</div>

@endsection