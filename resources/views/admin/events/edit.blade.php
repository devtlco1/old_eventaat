@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.event.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.events.update", [$event->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="form-group col-sm-12 col-md-3">
                    <label for="restaurant_id">{{ trans('cruds.event.fields.restaurant') }}</label>
                    <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id">
                        @foreach($restaurants as $id => $entry)
                            <option value="{{ $id }}" {{ (old('restaurant_id') ? old('restaurant_id') : $event->restaurant->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('restaurant'))
                        <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.restaurant_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-9">
                    <label for="title">{{ trans('cruds.event.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $event->title) }}">
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.title_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="starting_at">{{ trans('cruds.event.fields.starting_at') }}</label>
                    <input class="form-control datetime {{ $errors->has('starting_at') ? 'is-invalid' : '' }}" type="text" name="starting_at" id="starting_at" value="{{ old('starting_at', $event->starting_at) }}">
                    @if($errors->has('starting_at'))
                        <span class="text-danger">{{ $errors->first('starting_at') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.starting_at_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="ending_at">{{ trans('cruds.event.fields.ending_at') }}</label>
                    <input class="form-control datetime {{ $errors->has('ending_at') ? 'is-invalid' : '' }}" type="text" name="ending_at" id="ending_at" value="{{ old('ending_at', $event->ending_at) }}">
                    @if($errors->has('ending_at'))
                        <span class="text-danger">{{ $errors->first('ending_at') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.ending_at_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="old_price">{{ trans('cruds.event.fields.old_price') }}</label>
                    <input class="form-control {{ $errors->has('old_price') ? 'is-invalid' : '' }}" type="number" min="0" name="old_price" id="old_price" value="{{ old('old_price', $event->old_price) }}" step="0.01">
                    @if($errors->has('old_price'))
                        <span class="text-danger">{{ $errors->first('old_price') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.old_price_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="price">{{ trans('cruds.event.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" min="0" name="price" id="price" value="{{ old('price', $event->price) }}" step="0.01">
                    @if($errors->has('price'))
                        <span class="text-danger">{{ $errors->first('price') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.price_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="seats">{{ trans('cruds.event.fields.seats') }}</label>
                    <input class="form-control {{ $errors->has('seats') ? 'is-invalid' : '' }}" type="number" min="0" name="seats" id="seats" value="{{ old('seats', $event->seats) }}" step="1">
                    @if($errors->has('seats'))
                        <span class="text-danger">{{ $errors->first('seats') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.seats_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="privacy_id">{{ trans('cruds.event.fields.privacy') }}</label>
                    <select class="form-control select2 {{ $errors->has('privacy') ? 'is-invalid' : '' }}" name="privacy_id" id="privacy_id">
                        @foreach($privacies as $id => $entry)
                            <option value="{{ $id }}" {{ (old('privacy_id') ? old('privacy_id') : $event->privacy->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('privacy'))
                        <span class="text-danger">{{ $errors->first('privacy') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.privacy_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="features">{{ trans('cruds.event.fields.features') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('features') ? 'is-invalid' : '' }}" name="features[]" id="features" multiple>
                        @foreach($features as $id => $feature)
                            <option value="{{ $id }}" {{ (in_array($id, old('features', [])) || $event->features->contains($id)) ? 'selected' : '' }}>{{ $feature }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('features'))
                        <span class="text-danger">{{ $errors->first('features') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.features_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="discreption">{{ trans('cruds.event.fields.discreption') }}</label>
                    <textarea class="form-control {{ $errors->has('discreption') ? 'is-invalid' : '' }}" name="discreption" id="discreption">{{ old('discreption', $event->discreption) }}</textarea>
                    @if($errors->has('discreption'))
                        <span class="text-danger">{{ $errors->first('discreption') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.discreption_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="images">{{ trans('cruds.event.fields.images') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                    </div>
                    @if($errors->has('images'))
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.images_helper') }}</span>
                </div>
                @can('event_approve')
                <div class="form-group col-sm-12 col-md-12">
                    <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="approved" value="0">
                        <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ $event->approved || old('approved', 0) === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="approved">{{ trans('cruds.event.fields.approved') }}</label>
                    </div>
                    @if($errors->has('approved'))
                        <span class="text-danger">{{ $errors->first('approved') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.approved_helper') }}</span>
                </div>
                @endcan
                <div class="form-group col-sm-12 col-md-3">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.events.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
      uploadedImagesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImagesMap[file.name]
      }
      $('form').find('input[name="images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($event) && $event->images)
      var files = {!! json_encode($event->images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
@endsection
