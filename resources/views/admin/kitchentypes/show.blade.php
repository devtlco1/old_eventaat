@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.income.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            {{--  <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.incomes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>  --}}
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kitchentypes.fields.id') }}
                        </th>
                        <td>
                            {{ $kitchentypes->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kitchentypes.fields.title') }}
                        </th>
                        <td>
                            {{ $kitchentypes->name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kitchentypes.fields.titleAR') }}
                        </th>
                        <td style="white-space: normal; word-wrap: break-word; word-break: break-word;">
                            {{ $kitchentypes->name_ar }}
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kitchentypes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection