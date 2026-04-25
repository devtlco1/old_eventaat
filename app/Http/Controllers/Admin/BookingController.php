<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Privacy;
use App\Models\Restaurant;
use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        return Restaurant::findOrFail(1)->with(['events','city','stories','offers','contacts','user','chain'])->get();

        if(isset($_GET['type']) && $_GET['type']=='rest'){
            $bookings = Booking::whereNull('event_id')->with(['event', 'client', 'team','privacy'])->get();
            $view = 'admin.bookingRest.index';
        }else{
            $bookings = Booking::whereNull('restaurant_id')->with(['event', 'client', 'team','privacy'])->get();
            $view = 'admin.bookings.index';
        }

//        $bookings = Booking::with(['event', 'client', 'team','privacy'])->get();

        return view($view, compact('bookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clients = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $privacies = Privacy::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $view = isset($_GET['type']) && $_GET['type']=='rest' ? 'admin.bookingRest.create' : 'admin.bookings.create';


        return view($view, compact('clients', 'events','privacies','restaurants'));
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = Booking::create($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function approve($id)
    {
        $event = Booking::findOrFail($id);
        $event->update([
            'status' => 1
        ]);
        return redirect()->back();
    }

    public function decline($id)
    {
        $event = Booking::findOrFail($id);
        $event->update([
            'status' => 2
        ]);
        return redirect()->back();
    }


    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $events = Event::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $clients = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $privacies = Privacy::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('event', 'client', 'team','privacy');

        if($booking->event_id==null){
            $view = 'admin.bookingRest.edit';
        }else{
            $view = 'admin.bookings.edit';
        }
        return view($view, compact('booking', 'clients', 'events','privacies','restaurants'));
        }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('event', 'client', 'team','privacy');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        $bookings = Booking::find(request('ids'));

        foreach ($bookings as $booking) {
            $booking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
