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
                            {{ trans('cruds.income.fields.id') }}
                        </th>
                        <td>
                            {{ $pages->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pages.fields.title') }}
                        </th>
                        <td>
                            {{ $pages->Key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pages.fields.Value') }}
                        </th>
                        <td style="white-space: normal; word-wrap: break-word; word-break: break-word;">
                            {{ $pages->Value }}
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection