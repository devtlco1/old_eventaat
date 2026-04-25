@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="row">
                            @foreach([$settings1, $settings2, $settings3, $settings4, $settings5, $settings6, $settings7, $settings8, $settings9, $settings10] as $settings)
                                <div class="{{ $settings['column_class'] }}">
                                    <div class="info-box" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
                                        <span class="info-box-icon" style="background-color: #aa1f86; color: white; display: flex; align-items: center; justify-content: center; border-top-left-radius: 10px; border-bottom-left-radius: 10px; width: 80px;">
                                            <i class="fa fa-chart-line"></i>
                                        </span>
                                        <div class="info-box-content" style="padding-left: 90px;">
                                            <span class="info-box-text" style="font-size: 16px; font-weight: bold; color: #333;">{{ $settings['chart_title'] }}</span>
                                            <span class="info-box-number" style="font-size: 20px; color: #aa1f86;">{{ number_format($settings['total_number']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <canvas id="sales"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($events)>0)
    <div class="card">
        <div class="card-header">
            {{ trans('global.Pending_event') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.event.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.restaurant') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.starting_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.approved') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.privacy') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $key => $event)
                        <tr data-entry-id="{{ $event->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $event->id ?? '' }}
                            </td>
                            <td>
                                {{ $event->restaurant->name ?? '' }}
                            </td>
                            <td>
                                {{ $event->title ?? '' }}
                            </td>
                            <td>
                                {{ $event->starting_at ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $event->approved ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $event->approved ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $event->privacy->title ?? '' }}
                            </td>
                            <td>
                                @can('event_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.events.show', $event->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('event_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.events.edit', $event->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('event_delete')
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                                @if(!$event->approved)
                                    @can('event_approve')
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.events.approve', $event->id) }}">
                                            {{ trans('global.approve') }}
                                        </a>
                                    @endcan
                                @endif

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if(count($bookings)>0)
    <div class="card">
        <div class="card-header">
            {{ trans('global.Pending') }} {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Booking">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.event') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.client') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.adolt') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.children') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $booking->id ?? '' }}
                            </td>
                            <td>
                                {{ $booking->event->title ?? '' }}
                            </td>
                            <td>
                                {{ $booking->client->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->adolt ?? '' }}
                            </td>
                            <td>
                                {{ $booking->children ?? '' }}
                            </td>
                            <td>
                                <span class="btn {{$booking->status==1?'text-success':($booking->status==2?'text-danger':'')}}">{{$booking->status==1?'Approved':($booking->status==2?'Decline':'Pending')}}</span>
                            </td>
                            <td>
                                @can('booking_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.bookings.show', $booking->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('booking_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('booking_delete')
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                                @if($booking->status==null)
                                    @can('event_approve')
                                        <a class="btn btn-xs btn-success" href="{{ route('admin.bookings.approve', $booking->id) }}">
                                            {{ trans('global.approve') }}
                                        </a>
                                        <a class="btn btn-xs btn-warning" href="{{ route('admin.bookings.decline', $booking->id) }}">
                                            {{ trans('global.decline') }}
                                        </a>
                                    @endcan
                                @endif

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if(count($offers)>0)
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
                        </th>
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
                                            {{ trans('global.approve') }}
                                        </a>
                                    @endcan
                                @endif

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif


@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script type="module">
(async function() {
  // بيانات المبيعات
  const salesData = [
    { year: 2017, sales: 50 },
    { year: 2018, sales: 60 },
    { year: 2019, sales: 75 },
    { year: 2020, sales: 90 },
    { year: 2021, sales: 85 },
    { year: 2022, sales: 100 },
  ];

  // إنشاء الرسم البياني
  new Chart(
    document.getElementById('sales'),
    {
      type: 'line', // نوع الرسم البياني (خط)
      data: {
        labels: salesData.map(row => row.year), // المحاور (السنة)
        datasets: [
          {
            label: 'Annual Sales',
            data: salesData.map(row => row.sales), // البيانات
            borderColor: 'blue', // لون الخط
            borderWidth: 2,
            fill: false, // عدم تعبئة المساحة تحت الخط
            tension: 0.4, // انحناء الخط
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top',
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Year',
            }
          },
          y: {
            title: {
              display: true,
              text: 'Sales (in thousands)',
            },
            beginAtZero: true,
          }
        }
      }
    }
  );
})();
</script>
@endsection
