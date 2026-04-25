@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="event_id">{{ trans('cruds.booking.fields.event') }}</label>
                <select class="form-control select2 {{ $errors->has('event') ? 'is-invalid' : '' }}" name="event_id" id="event_id" required>
                    @foreach($events as $id => $entry)
                        <option value="{{ $id }}" {{ old('event_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <option value="{{ $id }}" {{ old('client_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <option value="{{ $id }}" {{ old('privacy_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('privacy'))
                    <span class="text-danger">{{ $errors->first('privacy') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.privacy_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="appointment">{{ trans('cruds.booking.fields.appointment') }}</label>
                <input class="form-control datetime {{ $errors->has('appointment') ? 'is-invalid' : '' }}" type="text" name="appointment" id="appointment" value="{{ old('appointment') }}" required>
                @if($errors->has('appointment'))
                    <span class="text-danger">{{ $errors->first('appointment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.appointment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="adolt">{{ trans('cruds.booking.fields.adolt') }}</label>
                <input class="form-control {{ $errors->has('adolt') ? 'is-invalid' : '' }}" type="number" min="0" name="adolt" id="adolt" value="{{ old('adolt', '') }}" step="1" required>
                @if($errors->has('adolt'))
                    <span class="text-danger">{{ $errors->first('adolt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.adolt_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="children">{{ trans('cruds.booking.fields.children') }}</label>
                <input class="form-control {{ $errors->has('children') ? 'is-invalid' : '' }}" type="number" min="0" name="children" id="children" value="{{ old('children', '') }}" step="1" required>
                @if($errors->has('children'))
                    <span class="text-danger">{{ $errors->first('children') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.children_helper') }}</span>
            </div>

            @can('booking_approve')
                <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ trans('cruds.booking.fields.approved') }}</label>
                </div>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
            </div>

            @endcan

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
