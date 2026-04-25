@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.story.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stories.store") }}{{isset($_GET["id"])?"?id=".$_GET["id"]:""}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('cruds.story.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif 
            </div>
            <div class="form-group">
                <label for="restaurant_id">{{ trans('cruds.story.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id" required>
                    @foreach($restaurants as $id => $entry)
                        <option value="{{ $id }}" {{ old('restaurant_id',$_GET["id"]??"") == $id ? 'selected' : '' }} @if(old('restaurant_id',$_GET["id"]??"") != $id) {{($_GET["id"]??"") == ""?'':'disabled'}}@endif>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.story.fields.restaurant_helper') }}</span>
            </div>
           
            <div class="form-group">
                <label for="file">{{ trans('cruds.story.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone" required>
                </div>
                @if($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.story.fields.file_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.stories.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($story) && $story->file)
      var file = {!! json_encode($story->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
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
@endsection
