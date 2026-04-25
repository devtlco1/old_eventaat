<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RestaurentsController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
//Route::post('/save-fcm-token', [\App\Http\Controllers\FcmController::class, 'saveToken']);
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

if (!Route::has('register')) {
    Route::get('register', function () {
        // Registration logic here
    })->name('register');
}

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::post('user/toggleApproval', 'UsersController@toggleApproval')->name('user.toggleApproval');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Expense Category
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Income Category
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Income
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expense Report
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    // Restaurents
    Route::delete('restaurents/destroy', 'RestaurentsController@massDestroy')->name('restaurents.massDestroy');
    Route::post('restaurents/media', 'RestaurentsController@storeMedia')->name('restaurents.storeMedia');
    Route::post('restaurents/ckmedia', 'RestaurentsController@storeCKEditorImages')->name('restaurents.storeCKEditorImages');
    Route::get('restaurents/{id}/website-url', [RestaurentsController::class, 'getWebsiteUrl'])->name('restaurents.getWebsiteUrl');
    Route::resource('restaurents', 'RestaurentsController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventsController@storeMedia')->name('events.storeMedia');
    Route::post('events/ckmedia', 'EventsController@storeCKEditorImages')->name('events.storeCKEditorImages');
    Route::get('events/approve/{id}', 'EventsController@approve')->name('events.approve');
    Route::resource('events', 'EventsController');

    // Stories
    Route::delete('stories/destroy', 'StoriesController@massDestroy')->name('stories.massDestroy');
    Route::post('stories/media', 'StoriesController@storeMedia')->name('stories.storeMedia');
    Route::post('stories/ckmedia', 'StoriesController@storeCKEditorImages')->name('stories.storeCKEditorImages');
    Route::resource('stories', 'StoriesController');

    // Privacy
    Route::delete('privacies/destroy', 'PrivacyController@massDestroy')->name('privacies.massDestroy');
    Route::resource('privacies', 'PrivacyController');

    // Features
    Route::delete('features/destroy', 'FeaturesController@massDestroy')->name('features.massDestroy');
    Route::resource('features', 'FeaturesController');

    // Offers
    Route::delete('offers/destroy', 'OffersController@massDestroy')->name('offers.massDestroy');
    Route::post('offers/media', 'OffersController@storeMedia')->name('offers.storeMedia');
    Route::get('offers/approve/{id}', 'OffersController@approve')->name('offers.approve');
    Route::post('offers/toggleApproval', 'OffersController@toggleApproval')->name('offers.toggleApproval');
    Route::resource('offers', 'OffersController');

    // Booking
    Route::delete('bookings/destroy', 'BookingController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingController');
    Route::get('bookings/approve/{id}', 'BookingController@approve')->name('bookings.approve');
    Route::get('bookings/decline/{id}', 'BookingController@decline')->name('bookings.decline');

    // Contacts
    Route::delete('contacts/destroy', 'ContactsController@massDestroy')->name('contacts.massDestroy');
    Route::resource('contacts', 'ContactsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');

    // Cities
    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CitiesController');

    Route::get('/doc', [HomeController::class, 'doc'])->name('doc.show');

    Route::get('/pages', [HomeController::class, 'pages'])->name('pages.index');
    Route::get('/pages/edit/{id}', [HomeController::class, 'pagesEdit'])->name('pages.edit');
    Route::put('/pages/update/{id}', [HomeController::class, 'pagesSaveUpdate'])->name('pages.update');
    Route::get('/pages/show/{id}', [HomeController::class, 'pagesShow'])->name('pages.show');

    Route::get('/accountant', [HomeController::class, 'accountantpages'])->name('accountant.index');
    Route::post('/accountantpages/markAsPaid/{id}', [HomeController::class, 'markAsPaid'])->name('accountantpages.markAsPaid');
    // Route::get('/accountant/edit/{id}', [HomeController::class, 'accountantpagesEdit'])->name('accountant.edit');
    // Route::put('/accountant/update/{id}', [HomeController::class, 'accountantpagesSaveUpdate'])->name('accountant.update');
    // Route::get('/accountant/show/{id}', [HomeController::class, 'accountantpagesShow'])->name('accountant.show');


    Route::get('/kitchentypes', [HomeController::class, 'kitchentypes'])->name('kitchentypes.index');
    Route::get('/kitchentypes/create', [HomeController::class, 'kitchentypesCreate'])->name('kitchentypes.create');
    Route::post('/kitchentypes/store', [HomeController::class, 'kitchentypesStore'])->name('kitchentypes.store');
    Route::get('/kitchentypes/edit/{id}', [HomeController::class, 'kitchentypesEdit'])->name('kitchentypes.edit');
    Route::put('/kitchentypes/update/{id}', [HomeController::class, 'kitchentypesSaveUpdate'])->name('kitchentypes.update');
    Route::get('/kitchentypes/show/{id}', [HomeController::class, 'kitchentypesShow'])->name('kitchentypes.show');
    Route::delete('/kitchentypes/destroy/{id}', [HomeController::class, 'kitchentypesDestroy'])->name('kitchentypes.destroy');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});






Route::group(['prefix' => 'Restaurant', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::post('user/toggleApproval', 'UsersController@toggleApproval')->name('user.toggleApproval');
    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::resource('teams', 'TeamController');

    // Expense Category
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // Income Category
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expense
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');

    // Income
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expense Report
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');

    // Restaurents
    Route::delete('restaurents/destroy', 'RestaurentsController@massDestroy')->name('restaurents.massDestroy');
    Route::post('restaurents/media', 'RestaurentsController@storeMedia')->name('restaurents.storeMedia');
    Route::post('restaurents/ckmedia', 'RestaurentsController@storeCKEditorImages')->name('restaurents.storeCKEditorImages');
    Route::get('restaurents/{id}/website-url', [RestaurentsController::class, 'getWebsiteUrl'])->name('restaurents.getWebsiteUrl');
    Route::resource('restaurents', 'RestaurentsController');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventsController@storeMedia')->name('events.storeMedia');
    Route::post('events/ckmedia', 'EventsController@storeCKEditorImages')->name('events.storeCKEditorImages');
    Route::get('events/approve/{id}', 'EventsController@approve')->name('events.approve');
    Route::post('events/toggleApproval', 'EventsController@toggleApproval')->name('events.toggleApproval');
    Route::resource('events', 'EventsController');

    // Stories
    Route::delete('stories/destroy', 'StoriesController@massDestroy')->name('stories.massDestroy');
    Route::post('stories/media', 'StoriesController@storeMedia')->name('stories.storeMedia');
    Route::post('stories/ckmedia', 'StoriesController@storeCKEditorImages')->name('stories.storeCKEditorImages');
    Route::resource('stories', 'StoriesController');

    // Privacy
    Route::delete('privacies/destroy', 'PrivacyController@massDestroy')->name('privacies.massDestroy');
    Route::resource('privacies', 'PrivacyController');

    // Features
    Route::delete('features/destroy', 'FeaturesController@massDestroy')->name('features.massDestroy');
    Route::resource('features', 'FeaturesController');

    // Offers
    Route::delete('offers/destroy', 'OffersController@massDestroy')->name('offers.massDestroy');
    Route::post('offers/media', 'OffersController@storeMedia')->name('offers.storeMedia');
    Route::get('offers/approve/{id}', 'OffersController@approve')->name('offers.approve');
    Route::post('offers/toggleApproval', 'OffersController@toggleApproval')->name('offers.toggleApproval');
    Route::resource('offers', 'OffersController');

    // Booking
    Route::delete('bookings/destroy', 'BookingController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingController');
    Route::get('bookings/approve/{id}', 'BookingController@approve')->name('bookings.approve');
    Route::get('bookings/decline/{id}', 'BookingController@decline')->name('bookings.decline');

    // Contacts
    Route::delete('contacts/destroy', 'ContactsController@massDestroy')->name('contacts.massDestroy');
    Route::resource('contacts', 'ContactsController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');

    // Cities
    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CitiesController');

    Route::get('/doc', [HomeController::class, 'doc'])->name('doc.show');

    Route::get('/pages', [HomeController::class, 'pages'])->name('pages.index');
    Route::get('/pages/edit/{id}', [HomeController::class, 'pagesEdit'])->name('pages.edit');
    Route::put('/pages/update/{id}', [HomeController::class, 'pagesSaveUpdate'])->name('pages.update');
    Route::get('/pages/show/{id}', [HomeController::class, 'pagesShow'])->name('pages.show');


    Route::get('/kitchentypes', [HomeController::class, 'kitchentypes'])->name('kitchentypes.index');
    Route::get('/kitchentypes/create', [HomeController::class, 'kitchentypesCreate'])->name('kitchentypes.create');
    Route::post('/kitchentypes/store', [HomeController::class, 'kitchentypesStore'])->name('kitchentypes.store');
    Route::get('/kitchentypes/edit/{id}', [HomeController::class, 'kitchentypesEdit'])->name('kitchentypes.edit');
    Route::put('/kitchentypes/update/{id}', [HomeController::class, 'kitchentypesSaveUpdate'])->name('kitchentypes.update');
    Route::get('/kitchentypes/show/{id}', [HomeController::class, 'kitchentypesShow'])->name('kitchentypes.show');
    Route::delete('/kitchentypes/destroy/{id}', [HomeController::class, 'kitchentypesDestroy'])->name('kitchentypes.destroy');

});
