
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{route('dashboard')}}">
            <img alt="Logo" src="{{ asset(Storage::url(siteSetting('logo'))) }}" class=" logo" style="width:150px;">
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="black" />
                </svg>
            </span>
        </div>
    </div>
    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y my-2 py-5 py-lg-8" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                @can('read-Dashboard')
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-uppercase fs-8 ls-1">Dashboard</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('dashboard')) active @endif" href="{{route('dashboard')}}">
                        <span class="menu-icon">
                            <i class="bi bi-house-door fs-2"></i>
                        </span>
                        <span class="menu-title">Home</span>
                    </a>
                </div>
                @endcan
                
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-uppercase fs-8 ls-1">Modules</span>
                    </div>
                </div>

                @can('read-LoadPlanner')
                <!-- Load Planner -->
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('admin.loadPlanner')) active @endif" href="{{route('admin.loadPlanner')}}">
                        <span class="menu-icon">
                            <i class="bi bi-truck fs-2"></i>
                        </span>
                        <span class="menu-title">Load Planner</span>
                    </a>
                </div>
                @endcan

                @can('read-Invoice')
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(Route::is('admin.invoice') || Route::is('admin.invoiceBatch')) here show @endif">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-receipt fs-2"></i>
                        </span>
                        <span class="menu-title">Invoices</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @can('read-Invoice')
                        <!-- Invoices -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.invoice')) active @endif" href="{{route('admin.invoice')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-receipt fs-3"></i>
                                </span>
                                <span class="menu-title">All Invoices</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-Invoice')
                        <!-- Batches -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.invoiceBatch')) active @endif" href="{{route('admin.invoiceBatch')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-box-seam fs-3"></i>
                                </span>
                                <span class="menu-title">Batches</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                @endcan

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(Route::is('admin.expenses') || Route::is('admin.driverSettlement') || Route::is('admin.taxForm')) here show @endif">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-calendar2-week fs-2"></i>
                        </span>
                        <span class="menu-title">Accounting</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @can('read-DriverSettlement')
                        <!-- Driver Settlements -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.driverSettlement')) active @endif" href="{{route('admin.driverSettlement')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-clipboard-check fs-3"></i>
                                </span>
                                <span class="menu-title">Driver Settlements</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-Expense')
                        <!-- Expenses -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.expenses')) active @endif" href="{{route('admin.expenses')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-cash-coin fs-3"></i>
                                </span>
                                <span class="menu-title">Expenses</span>
                            </a>
                        </div>
                        @endcan
                        
                        @can('read-FuelExpense')
                        <!-- Expenses -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.fuelExpense')) active @endif" href="{{route('admin.fuelExpense')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-droplet fs-3"></i>
                                </span>
                                <span class="menu-title">Fuel Expenses</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-TaxReport')
                        <!-- Profit & Loss -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.taxForm')) active @endif" href="{{route('admin.taxForm')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-card-heading fs-3"></i>
                                </span>
                                <span class="menu-title">1099 FORM</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>

                @can('read-Report')
                <!-- Reports -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(Route::is('admin.report.settlement') || Route::is('admin.report.factoring') || Route::is('admin.profitLoss') || Route::is('summary')) here show @endif">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-clipboard-data fs-2"></i>
                        </span>
                        <span class="menu-title">Reports</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        
                        <!-- Driver Settlement Reports -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.report.settlement')) active @endif" href="{{route('admin.report.settlement')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-clipboard-check fs-3"></i>
                                </span>
                                <span class="menu-title">Driver Settlement Reports</span>
                            </a>
                        </div>
                        
                        <!-- Factoring Fee Reports -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.report.factoring')) active @endif" href="{{route('admin.report.factoring')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-building fs-3"></i>
                                </span>
                                <span class="menu-title">Factoring Fee Reports</span>
                            </a>
                        </div>

                        @can('read-ProfitLoss')
                        <!-- Profit & Loss -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.profitLoss')) active @endif" href="{{route('admin.profitLoss')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-bar-chart-line fs-3"></i>
                                </span>
                                <span class="menu-title">Profit &amp; Loss</span>
                            </a>
                        </div>
                        @endcan
                        
                        @can('read-Summary')
                        <!-- Summary -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('summary')) active @endif" href="{{route('summary')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-speedometer fs-2"></i>
                                </span>
                                <span class="menu-title">Summary</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
                @endcan

                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-uppercase fs-8 ls-1">Management</span>
                    </div>
                </div>

                {{-- @can('read-Archive')
                <!-- Archives -->
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('admin.archive')) active @endif" href="{{route('admin.archive')}}">
                        <span class="menu-icon">
                            <i class="bi bi-archive fs-3"></i>
                        </span>
                        <span class="menu-title">Archives</span>
                    </a>
                </div>
                @endcan --}}

                @can('read-Invoice')
                <!-- Driver Applications -->
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('admin.driverApplication')) active @endif" href="{{route('admin.driverApplication')}}">
                        <span class="menu-icon">
                            <i class="bi bi-chat-right-text fs-3"></i>
                        </span>
                        <span class="menu-title">Driver Applications</span>
                    </a>
                </div>
                @endcan

                @can('read-Media')
                <!-- Media -->
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('unisharp.lfm.show')) active @endif" href="{{route('unisharp.lfm.show')}}">
                        <span class="menu-icon">
                            <i class="bi bi-collection fs-2"></i>
                        </span>
                        <span class="menu-title">Media</span>
                    </a>
                </div>
                @endcan

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(Route::is('admin.driver') || Route::is('admin.truck') || Route::is('admin.location') || Route::is('admin.customer') || Route::is('admin.factoringCompanies') || Route::is('admin.expenseCategory')) here show @endif">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-gear fs-2"></i>
                        </span>
                        <span class="menu-title">Settings</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        @can('read-Driver')
                        <!-- Drivers -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.driver')) active @endif" href="{{route('admin.driver')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-file-person fs-2"></i>
                                </span>
                                <span class="menu-title">Drivers</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-Truck')
                        <!-- Trucks -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.truck')) active @endif" href="{{route('admin.truck')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-truck-flatbed fs-2"></i>
                                </span>
                                <span class="menu-title">Trucks</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-Location')
                        <!-- Locations -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.location')) active @endif" href="{{route('admin.location')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-geo-alt fs-2"></i>
                                </span>
                                <span class="menu-title">Locations</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-Customer')
                        <!-- Customers -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.customer')) active @endif" href="{{route('admin.customer')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-pin-map fs-2"></i>
                                </span>
                                <span class="menu-title">Customers</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-Factoring')
                        <!-- Factoring Company -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.factoringCompanies')) active @endif" href="{{route('admin.factoringCompanies')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-building fs-2"></i>
                                </span>
                                <span class="menu-title">Factoring Companies</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-ExpenseCategory')
                        <!-- Expense Categories -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.expenseCategory')) active @endif" href="{{route('admin.expenseCategory')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-bar-chart-steps fs-3"></i>
                                </span>
                                <span class="menu-title">Expense Categories</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-ContactUs')
                        <!-- Contact Us -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.contacts')) active @endif" href="{{route('admin.contacts')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-inboxes fs-2"></i>
                                </span>
                                <span class="menu-title">Contact Us</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-DeductionCategory')
                        <!-- Deduction Categories -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.deductionCategory')) active @endif" href="{{route('admin.deductionCategory')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-card-list fs-3"></i>
                                </span>
                                <span class="menu-title">Deduction Categories</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-RecurringDeduction')
                        <!-- Recurring Deductions -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.recurringDeduction')) active @endif" href="{{route('admin.recurringDeduction')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-arrow-repeat fs-3"></i>
                                </span>
                                <span class="menu-title">Recurring Deductions</span>
                            </a>
                        </div>
                        @endcan

                        @can('read-StateCity')
                        <!-- States & Cities -->
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.stateCity')) active @endif" href="{{route('admin.stateCity')}}">
                                <span class="menu-icon">
                                    <i class="bi bi-map fs-3"></i>
                                </span>
                                <span class="menu-title">States &amp; Cities</span>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>

                @if(Auth::user()->role_id == 1)
                <!-- Advance Settings -->
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-uppercase fs-8 ls-1">Advance Settings</span>
                    </div>
                </div>
                @endif

                @can('read-Permission')
                <!-- Permissions -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(Route::is('admin.permissions') || Route::is('admin.permissions.view') || Route::is('admin.permissions.create') || Route::is('admin.permissions.edit')) here show @endif">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-shield-lock fs-2"></i>
                        </span>
                        <span class="menu-title">Permissions</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.permissions.create')) active @endif" href="{{route('admin.permissions.create')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Create Permission</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.permissions')) active @endif" href="{{route('admin.permissions')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Permissions</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endcan

                @if(Auth::user()->role_id == 1)
                <!-- Modules -->
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('admin.modules')) active @endif" href="{{route('admin.modules')}}">
                        <span class="menu-icon">
                            <i class="bi bi-layout-text-window-reverse fs-3"></i>
                        </span>
                        <span class="menu-title">Modules</span>
                    </a>
                </div>
                @endif

                @can('read-User')
                <!-- User Management -->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if(Route::is('admin.users') || Route::is('admin.users.view') || Route::is('admin.users.create') || Route::is('admin.users.edit')) here show @endif">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="bi bi-people fs-2"></i>
                        </span>
                        <span class="menu-title">User Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.users.create')) active @endif" href="{{route('admin.users.create')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Create User</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link @if(Route::is('admin.users')) active @endif" href="{{route('admin.users')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Users</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('read-Trash')
                <!-- Modules -->
                <div class="menu-item">
                    <a class="menu-link @if(Route::is('admin.trash')) active @endif" href="{{route('admin.trash')}}">
                        <span class="menu-icon">
                            <i class="bi bi-trash fs-3"></i>
                        </span>
                        <span class="menu-title">Trash</span>
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a onclick="$('#logoutForm').submit();"  class="btn btn-custom  w-100" >
            <span class="svg-icon svg-icon-1 svg-icon-danger ">{!! getSvg('arr076') !!}</span>
            <span class="btn-label">Logout</span>
        </a>
    </div>
</div>