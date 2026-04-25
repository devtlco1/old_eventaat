<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Offer;
use App\Models\Pag;
use App\Models\KitchenType;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        $settings1 = [
            'chart_title'           => 'Restaurant amount',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Restaurant',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'restaurent',
        ];

        $settings1['total_number'] = 0;
        if (class_exists($settings1['model'])) {
            $settings1['total_number'] = $settings1['model']::when(isset($settings1['filter_field']), function ($query) use ($settings1) {
                if (isset($settings1['filter_days'])) {
                    return $query->where($settings1['filter_field'], '>=',
                        now()->subDays($settings1['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings1['filter_period'])) {
                    switch ($settings1['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings1['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings1['aggregate_function'] ?? 'count'}($settings1['aggregate_field'] ?? '*');
        }

        $settings2 = [
            'chart_title'           => 'event amount',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Event',
            'group_by_field'        => 'starting_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'event',
        ];

        $settings2['total_number'] = 0;
        if (class_exists($settings2['model'])) {
            $settings2['total_number'] = $settings2['model']::when(isset($settings2['filter_field']), function ($query) use ($settings2) {
                if (isset($settings2['filter_days'])) {
                    return $query->where($settings2['filter_field'], '>=',
                        now()->subDays($settings2['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings2['filter_period'])) {
                    switch ($settings2['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings2['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings2['aggregate_function'] ?? 'count'}($settings2['aggregate_field'] ?? '*');
        }

        $settings3 = [
            'chart_title'           => 'approved event',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Event',
            'group_by_field'        => 'starting_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'event',
        ];

        $settings3['total_number'] = Event::where('approved','=',1)->get()->count();

        $settings4 = [
            'chart_title'           => 'Pending events',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Event',
            'group_by_field'        => 'starting_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'event',
        ];

        $settings4['total_number'] = Event::where('approved','<>',1)->get()->count();

        $settings5 = [
            'chart_title'           => 'user amount',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings5['total_number'] = 0;
        if (class_exists($settings5['model'])) {
            $settings5['total_number'] = $settings5['model']::when(isset($settings5['filter_field']), function ($query) use ($settings5) {
                if (isset($settings5['filter_days'])) {
                    return $query->where($settings5['filter_field'], '>=',
                        now()->subDays($settings5['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings5['filter_period'])) {
                    switch ($settings5['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings5['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings5['aggregate_function'] ?? 'count'}($settings5['aggregate_field'] ?? '*');
        }

        $settings6 = [
            'chart_title'           => 'call action',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Booking',
            'group_by_field'        => 'appointment',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'booking',
        ];

        $settings6['total_number'] = Booking::where('call_action','=',1)->get()->count();

        $settings7 = [
            'chart_title'           => 'last 30 days users',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\User',
            'group_by_field'        => 'email_verified_at',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'filter_days'           => '30',
            'group_by_field_format' => 'Y-m-d H:i:s',
            'column_class'          => 'col-md-6',
            'entries_number'        => '5',
            'translation_key'       => 'user',
        ];

        $settings7['total_number'] = 0;
        if (class_exists($settings7['model'])) {
            $settings7['total_number'] = $settings7['model']::when(isset($settings7['filter_field']), function ($query) use ($settings7) {
                if (isset($settings7['filter_days'])) {
                    return $query->where($settings7['filter_field'], '>=',
                        now()->subDays($settings7['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings7['filter_period'])) {
                    switch ($settings7['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings7['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings7['aggregate_function'] ?? 'count'}($settings7['aggregate_field'] ?? '*');
        }

        $settings8 = [
            'chart_title'           => 'Incomes',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Income',
            'group_by_field'        => 'entry_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'income',
        ];

        $settings8['total_number'] = 0;
        if (class_exists($settings8['model'])) {
            $settings8['total_number'] = $settings8['model']::when(isset($settings8['filter_field']), function ($query) use ($settings8) {
                if (isset($settings8['filter_days'])) {
                    return $query->where($settings8['filter_field'], '>=',
                        now()->subDays($settings8['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings8['filter_period'])) {
                    switch ($settings8['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings8['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings8['aggregate_function'] ?? 'count'}($settings8['aggregate_field'] ?? '*');
        }

        $settings9 = [
            'chart_title'           => 'Expenses',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Expense',
            'group_by_field'        => 'entry_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'expense',
        ];

        $settings9['total_number'] = 0;
        if (class_exists($settings9['model'])) {
            $settings9['total_number'] = $settings9['model']::when(isset($settings9['filter_field']), function ($query) use ($settings9) {
                if (isset($settings9['filter_days'])) {
                    return $query->where($settings9['filter_field'], '>=',
                        now()->subDays($settings9['filter_days'])->format('Y-m-d'));
                } elseif (isset($settings9['filter_period'])) {
                    switch ($settings9['filter_period']) {
                        case 'week': $start = date('Y-m-d', strtotime('last Monday'));
                        break;
                        case 'month': $start = date('Y-m') . '-01';
                        break;
                        case 'year': $start = date('Y') . '-01-01';
                        break;
                    }
                    if (isset($start)) {
                        return $query->where($settings9['filter_field'], '>=', $start);
                    }
                }
            })
                ->{$settings9['aggregate_function'] ?? 'count'}($settings9['aggregate_field'] ?? '*');
        }

        $settings10 = [
            'chart_title'           => 'Profit',
            'chart_type'            => 'number_block',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\Models\Expense',
            'group_by_field'        => 'entry_date',
            'group_by_period'       => 'day',
            'aggregate_function'    => 'sum',
            'aggregate_field'       => 'amount',
            'filter_field'          => 'created_at',
            'group_by_field_format' => 'Y-m-d',
            'column_class'          => 'col-md-3',
            'entries_number'        => '5',
            'translation_key'       => 'expense',
        ];

        $settings10['total_number'] = (int)$settings8['total_number'] - (int)$settings9['total_number'];

        $events = Event::where('approved','<>',1)-> with(['restaurant', 'privacy', 'features', 'team', 'media'])->get();
        $offers = Offer::whereNull('approved')-> with(['restaurant', 'team'])->get();
        $bookings = Booking::whereNull('status')->get();

        return view('home', compact('settings1', 'settings10', 'settings2', 'settings3', 'settings4', 'settings5', 'settings6', 'settings7', 'settings8', 'settings9','events','bookings','offers'));
    }

    public function doc(){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ep = env("api_end_point");
        return view('admin.doc',compact("ep"));
    }

    public function pages(){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Pag::all();
        // dd($pages);
        return view('admin.pages.index', compact('pages'));
    }
    public function pagesEdit($id){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Pag::where('id' , $id)->first();
        return view('admin.pages.edit', compact('pages'));
    }

    public function pagesShow($id){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Pag::where('id' , $id)->first();
        return view('admin.pages.show', compact('pages'));
    }


    public function pagesSaveUpdate(Request $request, $id)
    {
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'Key' => 'required|string|max:255',
            'Value' => 'required|string',
        ]);
        $pages = Pag::findOrFail($id);
       
        $pages->update([
            'Value' => $request->Value,
        ]);
    
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }



    public function kitchentypes(){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kitchentypes = KitchenType::all();
        // dd($kitchentypes);
        return view('admin.kitchentypes.index', compact('kitchentypes'));
    }

    public function kitchentypesCreate(){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.kitchentypes.create');
    }
    public function kitchentypesStore(Request $request){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ]);
        KitchenType::create($validatedData);

        $kitchentypes = KitchenType::all();
        return view('admin.kitchentypes.index', compact('kitchentypes'));
    }

    public function kitchentypesEdit($id){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kitchentypes = KitchenType::where('id' , $id)->first();
        return view('admin.kitchentypes.edit', compact('kitchentypes'));
    }

    public function kitchentypesShow($id){
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kitchentypes = KitchenType::where('id' , $id)->first();
        return view('admin.kitchentypes.show', compact('kitchentypes'));
    }


    public function kitchentypesSaveUpdate(Request $request, $id)
    {
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string',
        ]);
        $kitchentypes = KitchenType::findOrFail($id);
       
        $kitchentypes->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
        ]);
    
        return redirect()->route('admin.kitchentypes.index')->with('success', 'Page updated successfully.');
    }
    public function kitchentypesDestroy($id)
    {
        abort_if(!auth()->user()->roles->contains(1), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $kitchenType = KitchenType::findOrFail($id);
        $kitchenType->delete();
        return redirect()->route('admin.kitchentypes.index')->with('success', 'Kitchen Type deleted successfully.');
    }


    public function accountantpages()
    {
        $Booking = Booking::with('restaurant')->whereNull('team_id')->get();
        $storesWithChildren = $Booking->where('restaurant_id', '!=', null)->groupBy('restaurant_id')->map(function ($item) {
            return $item->count();
        });

        $Booking->storesWithChildren = $storesWithChildren;

        $totalAmountPerRestaurant = $storesWithChildren->map(function ($count) {
            return $count * 2500;
        });

        // Calculate 5% of the total ticket price for evening events
        $eveningEvents = Event::where('type', 'evening')->get();
        $eventsWithChildren = $eveningEvents->groupBy('restaurant_id')->map(function ($item) {
            return $item->count();
        });

        $totalEveningEventAmountPerRestaurant = $eventsWithChildren->map(function ($count, $restaurantId) use ($eveningEvents) {
            $totalPrice = $eveningEvents->where('restaurant_id', $restaurantId)->sum('price');
            return $totalPrice * 0.05;
        });

        return view('admin.accountantpages.index', compact('Booking', 'storesWithChildren', 'totalAmountPerRestaurant', 'totalEveningEventAmountPerRestaurant'));
    }

    public function markAsPaid($id)
    {
        Booking::where('restaurant_id', $id)->update(['team_id' => 1]);
        $Booking = Booking::with('restaurant')->whereNull('team_id')->get();
        $storesWithChildren = $Booking->where('restaurant_id', '!=', null)->groupBy('restaurant_id')->map(function ($item) {
            return $item->count();
        });

        $Booking->storesWithChildren = $storesWithChildren;

        $totalAmountPerRestaurant = $storesWithChildren->map(function ($count) {
            return $count * 2500;
        });
        return view('admin.accountantpages.index', compact('Booking', 'storesWithChildren', 'totalAmountPerRestaurant'));
    }    
}


