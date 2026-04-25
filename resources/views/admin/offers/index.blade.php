@extends('layouts.admin')
@section('content')
@can('offer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.offers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.offer.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.offer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Offer">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.restaurant') }}
                        </th>ـ
                        <th>
                            {{ trans('cruds.offer.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.starting_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.approved') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $key => $offer)
                        <tr data-entry-id="{{ $offer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $offer->id ?? '' }}
                            </td>
                            <td>
                                {{ $offer->restaurant->name ?? '' }}
                            </td>
                            <td>
                                {{ $offer->title ?? '' }}
                            </td>
                            <td>
                                {{ $offer->starting_at ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $offer->approved ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $offer->approved ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('offer_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.offers.show', $offer->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('offer_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.offers.edit', $offer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('offer_delete')
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                                @if(!$offer->approved)
                                    @can('offer_approve')
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.offers.approve', $offer->id) }}">
                                            {{ trans('global.approve'
                                            ) }}
                                        </a>
                                    @endcan
                                @endif

                                @can('offer_approve')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $offer->id }}" {{ $offer->approved ? 'checked' : '' }} onclick="toggleApproval({{ $offer->id }})">
                                    <label class="form-check-label" for="flexSwitchCheckDefault{{ $offer->id }}">{{ $offer->approved ? trans('global.unapprove') :trans('global.approve') }}</label>
                                </div>
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
@can('offer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.offers.massDestroy') }}",
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
  let table = $('.datatable-Offer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

function toggleApproval(offerId) {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        method: 'POST',
        url: "{{ route('admin.offers.toggleApproval') }}",
        data: { id: offerId },
        dataType: 'json', 
        success: function(response) {
            console.error("response:", response);
            if (response.success) {
                window.location.reload();
            } else {
                console.error("Error:", response);
            }
        },
        error: function(xhr) {
            console.error("AJAX Error:", xhr.responseText);
            window.location.reload();
        }
    });
}
</script>
@endsection
