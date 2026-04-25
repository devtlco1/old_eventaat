<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(\Illuminate\Support\Facades\Auth::user()->roles->contains(1))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs("admin.doc") ? "active" : "" }}" href="{{ route("admin.doc.show") }}">
                            <p>
                                {{ trans('global.doc') }}
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/teams*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }} {{ request()->is("admin/teams*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('team_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.teams.index") }}" class="nav-link {{ request()->is("admin/teams") || request()->is("admin/teams/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-users">

                                        </i>
                                        <p>
                                            {{ trans('cruds.team.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('index_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/privacies*") ? "menu-open" : "" }} {{ request()->is("admin/features*") ? "menu-open" : "" }} {{ request()->is("admin/cities*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/privacies*") ? "active" : "" }} {{ request()->is("admin/features*") ? "active" : "" }} {{ request()->is("admin/cities*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.index.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('privacy_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.privacies.index") }}" class="nav-link {{ request()->is("admin/privacies") || request()->is("admin/privacies/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-secret">

                                        </i>
                                        <p>
                                            {{ trans('cruds.privacy.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('feature_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.features.index") }}" class="nav-link {{ request()->is("admin/features") || request()->is("admin/features/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-feather-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.feature.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('city_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cities.index") }}" class="nav-link {{ request()->is("admin/cities") || request()->is("admin/cities/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.city.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('kitchentypes_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.kitchentypes.index") }}" class="nav-link {{ (request()->is("admin/kitchentypes") || request()->is("admin/kitchentypes/*")) && !isset($_GET['type']) ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt"></i>
                                        <p>
                                        {{ trans('cruds.kitchentypes.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('expense_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/expense-categories*") ? "menu-open" : "" }} {{ request()->is("admin/income-categories*") ? "menu-open" : "" }} {{ request()->is("admin/expenses*") ? "menu-open" : "" }} {{ request()->is("admin/incomes*") ? "menu-open" : "" }} {{ request()->is("admin/expense-reports*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/expense-categories*") ? "active" : "" }} {{ request()->is("admin/income-categories*") ? "active" : "" }} {{ request()->is("admin/expenses*") ? "active" : "" }} {{ request()->is("admin/incomes*") ? "active" : "" }} {{ request()->is("admin/expense-reports*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-money-bill">

                            </i>
                            <p>
                                {{ trans('cruds.expenseManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('expense_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-categories.index") }}" class="nav-link {{ request()->is("admin/expense-categories") || request()->is("admin/expense-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expenseCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_category_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.income-categories.index") }}" class="nav-link {{ request()->is("admin/income-categories") || request()->is("admin/income-categories/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-list">

                                        </i>
                                        <p>
                                            {{ trans('cruds.incomeCategory.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('expense_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expenses.index") }}" class="nav-link {{ request()->is("admin/expenses") || request()->is("admin/expenses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-arrow-circle-right">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expense.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('income_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.incomes.index") }}" class="nav-link {{ request()->is("admin/incomes") || request()->is("admin/incomes/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-arrow-circle-right">

                                        </i>
                                        <p>
                                            {{ trans('cruds.income.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('expense_report_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.expense-reports.index") }}" class="nav-link {{ request()->is("admin/expense-reports") || request()->is("admin/expense-reports/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-chart-line">

                                        </i>
                                        <p>
                                            {{ trans('cruds.expenseReport.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('restaurent_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.restaurents.index") }}" class="nav-link {{ request()->is("admin/restaurents") || request()->is("admin/restaurents/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-utensils">

                            </i>
                            <p>
                                {{ trans('cruds.restaurent.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('event_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.events.index") }}" class="nav-link {{ request()->is("admin/events") || request()->is("admin/events/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bullhorn">

                            </i>
                            <p>
                                {{ trans('cruds.event.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('story_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.stories.index") }}" class="nav-link {{ request()->is("admin/stories") || request()->is("admin/stories/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-cogs">

                            </i>
                            <p>
                                {{ trans('cruds.story.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('offer_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.offers.index") }}" class="nav-link {{ request()->is("admin/offers") || request()->is("admin/offers/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-hand-holding-heart">

                            </i>
                            <p>
                                {{ trans('cruds.offer.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('booking_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.bookings.index") }}" class="nav-link {{ (request()->is("admin/bookings") || request()->is("admin/bookings/*")) && !isset($_GET['type']) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-shopping-cart">

                            </i>
                            <p>
                                Event {{ trans('cruds.booking.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('booking_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.bookings.index") }}?type=rest" class="nav-link {{ (request()->is("admin/bookings") || request()->is("admin/bookings/*")) && isset($_GET['type'])  ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-shopping-cart">

                            </i>
                            <p>
                                Restaurant {{ trans('cruds.booking.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('contact_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.contacts.index") }}" class="nav-link {{ request()->is("admin/contacts") || request()->is("admin/contacts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-phone-square">

                            </i>
                            <p>
                                {{ trans('cruds.contact.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
             
                @can('pages_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.pages.index") }}" class="nav-link {{ (request()->is("admin/pages") || request()->is("admin/pages/*")) && !isset($_GET['type']) ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-file-alt"></i>
                            <p>
                              {{ trans('cruds.pages.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route("admin.systemCalendar") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                {{--  @can('accountant')  --}}
                   <li class="nav-item">
                        <a href="{{ route("admin.accountant.index") }}" class="nav-link {{ (request()->is("admin/accountant") || request()->is("admin/accountant/*")) && !isset($_GET['type']) ? "active" : "" }}">
                            <i class="fa-fw fa fa-calculator nav-icon">
                            </i>
                            <p>
                                {{ trans("global.accountant") }}
                            </p>
                        </a>
                    </li>
               {{--  @endcan  --}}
                @if(\Illuminate\Support\Facades\Schema::hasColumn('teams', 'owner_id') && \App\Models\Team::where('owner_id', auth()->user()->id)->exists())
                    <li class="nav-item">
                        <a class="{{ request()->is("admin/team-members") || request()->is("admin/team-members/*") ? "active" : "" }} nav-link" href="{{ route("admin.team-members.index") }}">
                            <i class="fa-fw fa fa-users nav-icon">
                            </i>
                            <p>
                                {{ trans("global.team-members") }}
                            </p>
                        </a>
                    </li>
                @endif
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
