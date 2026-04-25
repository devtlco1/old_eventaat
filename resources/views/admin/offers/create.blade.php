@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.offer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.offers.store") }}{{isset($_GET["id"])?"?id=".$_GET["id"]:""}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="form-group col-sm-12 col-md-3">
                    <label for="restaurant_id">{{ trans('cruds.offer.fields.restaurant') }}</label>
                    <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id">
                        @foreach($restaurants as $id => $entry)
                            <option value="{{ $id }}" {{ old('restaurant_id',$_GET["id"]??"") == $id ? 'selected' : '' }} @if(old('restaurant_id',$_GET["id"]??"") != $id) {{($_GET["id"]??"") == ""?'':'disabled'}}@endif>{{ $entry }}</option>
{{--                            <option value="{{ $id }}" {{ old('restaurant_id',$_GET["id"]??"") == $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                            <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
                        @endforeach
                    </select>
                    @if($errors->has('restaurant_id'))
                        <span class="text-danger">{{ $errors->first('restaurant_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.restaurant_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="title">{{ trans('cruds.offer.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.title_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="starting_at">{{ trans('cruds.offer.fields.starting_at') }}</label>
                    <input class="form-control datetime {{ $errors->has('starting_at') ? 'is-invalid' : '' }}" type="text" name="starting_at" id="starting_at" value="{{ old('starting_at') }}">
                    @if($errors->has('starting_at'))
                        <span class="text-danger">{{ $errors->first('starting_at') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.starting_at_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-3">
                    <label for="ending_at">{{ trans('cruds.offer.fields.ending_at') }}</label>
                    <input class="form-control datetime {{ $errors->has('ending_at') ? 'is-invalid' : '' }}" type="text" name="ending_at" id="ending_at" value="{{ old('ending_at') }}">
                    @if($errors->has('ending_at'))
                        <span class="text-danger">{{ $errors->first('ending_at') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.ending_at_helper') }}</span>
                </div>
                <div class="form-group col-sm-12 col-md-8">
                    <label for="disception">{{ trans('cruds.offer.fields.disception') }}</label>
                    <textarea class="form-control {{ $errors->has('disception') ? 'is-invalid' : '' }}" name="disception" id="disception">{{ old('disception') }}</textarea>
                    @if($errors->has('disception'))
                        <span class="text-danger">{{ $errors->first('disception') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.disception_helper') }}</span>
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="images">{{ trans('cruds.event.fields.images') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                    </div>
                    @if($errors->has('images'))
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.images_helper') }}</span>
                </div>

                {{--                <div class="form-group col-sm-12 col-md-12">--}}
{{--                    <div class="form-check {{ $errors->has('public') ? 'is-invalid' : '' }}">--}}
{{--                        <input type="hidden" name="public" value="0">--}}
{{--                        <input class="form-check-input" type="checkbox" name="public" id="public" value="1" {{ old('public', 0) == 1 || old('public') === null ? 'checked' : '' }}>--}}
{{--                        <label class="form-check-label" for="public">{{ trans('cruds.offer.fields.public') }}</label>--}}
{{--                    </div>--}}
{{--                    @if($errors->has('public'))--}}
{{--                        <span class="text-danger">{{ $errors->first('public') }}</span>--}}
{{--                    @endif--}}
{{--                    <span class="help-block">{{ trans('cruds.offer.fields.public_helper') }}</span>--}}
{{--                </div>--}}

                <div class="form-group col-sm-12 col-md-12">
                    <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="approved" value="0">
                        <input class="form-check-input" type="checkbox" name="approved" id="approved" value="1" {{ old('approved', 0) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="approved">{{ trans('cruds.event.fields.approved') }}</label>
                    </div>
                    @if($errors->has('approved'))
                        <span class="text-danger">{{ $errors->first('approved') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.approved_helper') }}</span>
                </div>

                <div class="form-group col-sm-12 col-md-12">
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
        url: '{{ route('admin.offers.storeMedia') }}',
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
            @if(isset($offer) && $offer->images)
            var files = {!! json_encode($offer->images) !!}
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
