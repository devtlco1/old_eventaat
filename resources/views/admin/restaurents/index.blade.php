@extends('layouts.admin')
@section('content')
@can('restaurent_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.restaurents.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.restaurent.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.restaurent.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Restaurent">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.restaurent.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurent.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurent.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurent.fields.website_url') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurents as $key => $restaurent)
                        <tr data-entry-id="{{ $restaurent->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $restaurent->id ?? '' }}
                            </td>
                            <td>
                                {{ $restaurent->name ?? '' }}
                            </td>
                            <td>
                                {{ $restaurent->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $restaurent->website_url ?? '' }}
                            </td>
                            <td>
                                @can('restaurent_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.restaurents.show', $restaurent->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('restaurent_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.restaurents.edit', $restaurent->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('restaurent_delete')
                                    <form action="{{ route('admin.restaurents.destroy', $restaurent->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('restaurent_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.restaurents.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Restaurent:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection