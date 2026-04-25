@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.update", [$booking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="event_id">{{ trans('cruds.booking.fields.event') }}</label>
                <select class="form-control select2 {{ $errors->has('event') ? 'is-invalid' : '' }}" name="event_id" id="event_id" required>
                    @foreach($events as $id => $entry)
                        <option value="{{ $id }}" {{ (old('event_id') ? old('event_id') : $booking->event->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('event'))
                    <span class="text-danger">{{ $errors->first('event') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.event_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="client_id">{{ trans('cruds.booking.fields.client') }}</label>
                <select class="form-control select2 {{ $errors->has('client') ? 'is-invalid' : '' }}" name="client_id" id="client_id" required>
                    @foreach($clients as $id => $entry)
                        <option value="{{ $id }}" {{ (old('client_id') ? old('client_id') : $booking->client->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('client'))
                    <span class="text-danger">{{ $errors->first('client') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.client_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="privacy_id">{{ trans('cruds.event.fields.privacy') }}</label>
                <select class="form-control select2 {{ $errors->has('privacy') ? 'is-invalid' : '' }}" name="privacy_id" id="privacy_id" required>
                    @foreach($privacies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('privacy_id') ? old('privacy_id') : $booking->privacy->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('privacy'))
                    <span class="text-danger">{{ $errors->first('privacy') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.privacy_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="appointment">{{ trans('cruds.booking.fields.appointment') }}</label>
                <input class="form-control datetime {{ $errors->has('appointment') ? 'is-invalid' : '' }}" type="text" name="appointment" id="appointment" value="{{ old('appointment', $booking->appointment) }}" required>
                @if($errors->has('appointment'))
                    <span class="text-danger">{{ $errors->first('appointment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.appointment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="adolt">{{ trans('cruds.booking.fields.adolt') }}</label>
                <input class="form-control {{ $errors->has('adolt') ? 'is-invalid' : '' }}" type="number" min="0" name="adolt" id="adolt" value="{{ old('adolt', $booking->adolt) }}" step="1" required>
                @if($errors->has('adolt'))
                    <span class="text-danger">{{ $errors->first('adolt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.adolt_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="children">{{ trans('cruds.booking.fields.children') }}</label>
                <input class="form-control {{ $errors->has('children') ? 'is-invalid' : '' }}" type="number" min="0" name="children" id="children" value="{{ old('children', $booking->children) }}" step="1" required>
                @if($errors->has('children'))
                    <span class="text-danger">{{ $errors->first('children') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.children_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
