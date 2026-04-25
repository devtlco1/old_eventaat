@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pages.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pages.update", [$pages->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{--  @dd($pages)  --}}
            <div class="form-group">
                <label class="required" for="Key">{{ trans('cruds.pages.fields.title') }}</label>
                <input class="form-control {{ $errors->has('Key') ? 'is-invalid' : '' }}" 
                       type="text" name="Key" id="Key" 
                       Value="{{ old('Key', $pages->Key) }}" 
                       readonly required>
                @if($errors->has('Key'))
                    <span class="text-danger">{{ $errors->first('Key') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.entry_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="Value">{{ trans('cruds.pages.fields.Value') }}</label>
                <textarea class="form-control {{ $errors->has('Value') ? 'is-invalid' : '' }}" 
                          name="Value" id="Value" 
                          required>{{ old('Value', $pages->Value) }}</textarea>
                @if($errors->has('Value'))
                    <span class="text-danger">{{ $errors->first('Value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.income.fields.amount_helper') }}</span>
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
