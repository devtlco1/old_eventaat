@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.restaurent.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.restaurents.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="city_id">{{ trans('cruds.restaurent.fields.city') }}</label>
                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id" required>
                        @foreach($cities as $id => $entry)
                            <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('city_id'))
                        <span class="text-danger">{{ $errors->first('city_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.city_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="team_id">{{ trans('cruds.restaurent.fields.team') }}</label>
                    <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="team_id" id="team_id" >
                        @foreach($restaurants as $id => $entry)
                            <option value="{{ $id }}" {{ old('team_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('restaurant'))
                        <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.restaurant_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label class="required" for="name">{{ trans('cruds.restaurent.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.name_helper') }}</span>
                </div<
                <div class="form-group col-sm-12 col-md-6">
                    <label class="required" for="email">{{ trans('cruds.restaurent.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}" required>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label class="required" for="mobile">{{ trans('cruds.restaurent.fields.mobile') }}</label><br/>
                    <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="tel" name="mobile" id="mobile" value="{{ old('mobile', '') }}" required>
                    <input class="form-control hidden" type="text" name="country_code" id="country_code_mobile" value="{{ old('country_code', '964') }}" hidden>
                    <input class="form-control hidden" type="text" name="cc" id="cc_mobile" value="{{ old('cc', 'iq') }}" hidden>
                    @if($errors->has('mobile'))
                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.mobile_helper') }}</span>
                </div>
                

                <div class="form-group col-sm-12 col-md-6">
                    <label class="required" for="numberolder">{{ trans('cruds.restaurent.fields.numberolder') }}</label>
                    <input class="form-control {{ $errors->has('numberolder') ? 'is-invalid' : '' }}" type="number" min="0" name="numberolder" id="numberolder" value="{{ old('numberolder', '') }}" required>
                    @if($errors->has('numberolder'))
                        <span class="text-danger">{{ $errors->first('numberolder') }}</span>
                    @endif
                    {{--  <span class="help-block">{{ trans('cruds.restaurent.fields.name_helper') }}</span>  --}}
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="features">{{ trans('cruds.restaurent.fields.features') }}</label>
                    <select class="form-control required select2 {{ $errors->has('features') ? 'is-invalid' : '' }}" name="features[]" id="features" multiple required>
                        @foreach($features as $feature)
                            <option value="{{ $feature->id }}" {{ in_array($feature->id, old('features', [])) ? 'selected' : '' }}>
                                {{ $feature->title }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('features'))
                        <span class="text-danger">{{ $errors->first('features') }}</span>
                    @endif
                    {{--  <span class="help-block">{{ trans('cruds.restaurent.fields.features') }}</span>  --}}
                </div>
                
                <div class="form-group col-sm-12 col-md-6">
                    <label for="kitchen_types">{{ trans('cruds.restaurent.fields.kitchen_types') }}</label>
                    <select class="form-control required select2 {{ $errors->has('kitchen_types') ? 'is-invalid' : '' }}" name="kitchen_types[]" id="kitchen_types" multiple required>
                        @foreach($kitchen_types as $kitchen_type)
                            <option value="{{ $kitchen_type->id }}" {{ in_array($kitchen_type->id, old('kitchen_types', [])) ? 'selected' : '' }}>
                                {{ $kitchen_type->name_en }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('kitchen_types'))
                        <span class="text-danger">{{ $errors->first('kitchen_types') }}</span>
                    @endif
                    {{--  <span class="help-block">{{ trans('cruds.restaurent.fields.kitchen_types_helper') }}</span>  --}}
                </div>
                
                <div class="form-group col-sm-12 col-md-6">
                    <label for="privacies">{{ trans('cruds.restaurent.fields.privacies') }}</label>
                    <select class="form-control required select2 {{ $errors->has('privacies') ? 'is-invalid' : '' }}" name="privacies[]" id="privacies" multiple required>
                        @foreach($privacies as $privacy)
                            <option value="{{ $privacy->id }}" {{ in_array($privacy->id, old('privacies', [])) ? 'selected' : '' }}>
                                {{ $privacy->title }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('privacies'))
                        <span class="text-danger">{{ $errors->first('privacies') }}</span>
                    @endif
                    {{--  <span class="help-block">{{ trans('cruds.restaurent.fields.privacies_helper') }}</span>  --}}
                </div>
                




                <div class="form-group col-sm-12 col-md-6">
                    <label for="address">{{ trans('cruds.restaurent.fields.address') }}</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}" required>
                    @if($errors->has('address'))
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.address_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="website_url">{{ trans('cruds.restaurent.fields.website_url') }}</label>
                    <input class="form-control {{ $errors->has('website_url') ? 'is-invalid' : '' }}" type="text" name="website_url" id="website_url" value="{{ old('website_url', '') }}">
                    @if($errors->has('website_url'))
                        <span class="text-danger">{{ $errors->first('website_url') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.website_url_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="menu_url">{{ trans('cruds.restaurent.fields.menu_url') }}</label>
                    <input class="form-control {{ $errors->has('menu_url') ? 'is-invalid' : '' }}" type="text" name="menu_url" id="menu_url" value="{{ old('menu_url', '') }}" required>
                    @if($errors->has('menu_url'))
                        <span class="text-danger">{{ $errors->first('menu_url') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.menu_url_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="location_url">{{ trans('cruds.restaurent.fields.location_url') }}</label>
                    <input class="form-control {{ $errors->has('location_url') ? 'is-invalid' : '' }}" type="text" name="location_url" id="location_url" value="{{ old('location_url', '') }}" required>
                    @if($errors->has('location_url'))
                        <span class="text-danger">{{ $errors->first('location_url') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.location_url_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="logo">{{ trans('cruds.restaurent.fields.logo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                    </div>
                    @if($errors->has('logo'))
                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.logo_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="menu_image">{{ trans('cruds.restaurent.fields.menu_image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('menu_image') ? 'is-invalid' : '' }}" id="menu_image-dropzone">
                    </div>
                    @if($errors->has('menu_image'))
                        <span class="text-danger">{{ $errors->first('menu_image') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.menu_image_helper') }}</span>
                </div>

                <div class="form-group col-sm-12 col-md-6">
                    <label for="images">{{ trans('cruds.restaurent.fields.images') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                    </div>
                    @if($errors->has('images'))
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.restaurent.fields.images_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-6">
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
    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.restaurents.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($restaurent) && $restaurent->logo)
      var file = {!! json_encode($restaurent->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    Dropzone.options.menuImageDropzone = {
    url: '{{ route('admin.restaurents.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
        $('form').find('input[name="menu_image"]').remove()
        $('form').append('<input type="hidden" name="menu_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
          $('form').find('input[name="menu_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
        @if(isset($restaurent) && $restaurent->menu_image)
            var file = {!! json_encode($restaurent->menu_image) !!}
            this.options.addedfile.call(this, file)
            this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="menu_image" value="' + file.file_name + '">')
            this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.restaurents.storeMedia') }}',
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
@if(isset($restaurent) && $restaurent->images)
      var files = {!! json_encode($restaurent->images) !!}
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
