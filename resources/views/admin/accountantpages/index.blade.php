@extends('layouts.admin')
@section('content')
{{--  @can('offer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.offers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.offer.title_singular') }}
            </a>
        </div>
    </div>
@endcan  --}}
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
                        {{--  <th>  --}}
                            {{--  {{ trans('cruds.restaurant.fields.id') }}  --}}
                        {{--  </th>  --}}
                        <th>
                            {{ trans('cruds.restaurent.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurent.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurent.fields.address') }}
                        </th>
                        {{--  <th>
                            {{ trans('cruds.restaurant.fields.website_url') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurant.fields.menu_url') }}
                        </th>  --}}
                        <th>
                            {{ trans('cruds.restaurent.fields.total_amount') }}
                        </th>
                        <th>
                            {{ trans('global.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($storesWithChildren as $restaurantId => $count)
                        @php
                            $restaurant = $Booking->where('restaurant_id', $restaurantId)->first()->restaurant;
                            $totalAmount = $totalAmountPerRestaurant[$restaurantId];
                        @endphp
                        <tr>
                            <td>

                            </td>
                            {{--  <td>
                                {{ $restaurant->id ?? '' }}
                            </td>  --}}
                            <td>
                                {{ $restaurant->name ?? '' }}
                            </td>
                            <td>
                                {{ $restaurant->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $restaurant->address ?? '' }}
                            </td>
                            {{--  <td>
                                <a href="{{ $restaurant->website_url ?? '' }}" target="_blank">{{ $restaurant->website_url ?? '' }}</a>
                            </td>
                            <td>
                                <a href="{{ $restaurant->menu_url ?? '' }}" target="_blank">{{ $restaurant->menu_url ?? '' }}</a>
                            </td>  --}}
                            <td>
                                {{ $totalAmount ?? '' }}
                            </td>
                            <td>
                                <form action="{{ route('admin.accountantpages.markAsPaid', $restaurantId) }}" method="POST" class="mark-as-paid-form">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-primary mark-as-paid-btn">{{ trans('cruds.restaurent.fields.payd') }}</button>
                                </form>                                
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

        $(document).on('click', '.mark-as-paid-btn', function() {
            if (confirm('{{ trans('global.areYouSure') }}')) {
                var form = $(this).closest('form');
                $.post(form.attr('action'), form.serialize(), function(response) {
                    alert('Payment marked as paid successfully.');
                    location.reload();
                }).fail(function() {
                    alert('An error occurred while processing the payment.');
                });
            }
        });        
    });
</script>
@endsection
