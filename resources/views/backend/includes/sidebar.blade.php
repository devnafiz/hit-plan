<aside class="main-sidebar sidebar-light-lightblue elevation-0">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img sizes="32x32" src="{{ asset('img/logo/' . get_setting('fabicon')) }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ get_setting('app_name_short') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <x-utils.link class="nav-link" :href="route('admin.dashboard')" icon="fa fa-tachometer-alt" :text="__('Dashboard')">
                    </x-utils.link>
                </li>
                @if (
                    $logged_in_user->hasAllAccess() ||
                        $logged_in_user->can('ledger index') ||
                        $logged_in_user->can('ledger edit') ||
                        $logged_in_user->can('ledger create'))

                    <li
                        class="nav-item has-treeview {{ activeClass(Route::is('admin.ledger.*') || Route::is('admin.ledger.search-result'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(
                            Route::is('admin.ledger.*') || Route::is('admin.ledger.search-result'),
                            'active',
                        )" href="#" icon="fa fa-address-book"
                            rightIcon="fas fa-angle-left right" :text="__('রেলভুমি রেকর্ড ব্যবস্থাপনা')">
                        </x-utils.link>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.ledger.create')" :active="activeClass(Route::is('admin.ledger.create'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('রেলভুমির রেকর্ড এন্ট্রি')"></x-utils.link>
                            </li>
                            <!-- <li class="nav-item">
                            <x-utils.link class="nav-link" :href="route('admin.ledger.index')" :active="activeClass(Route::is('admin.ledger.index'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('খতিয়ান ও দাগ সমুহ')"></x-utils.link>
                        </li> -->
                            @if ($logged_in_user->can('ledger index'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.ledger.search-result')" :active="activeClass(Route::is('admin.ledger.search-result'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('রেলভুমির এন্ট্রিকৃত রেকর্ড')"></x-utils.link>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li
                    class="nav-item has-treeview {{ activeClass(Route::is('admin.agriculture.*') || Route::is('admin.agriculture-balam.create') || Route::is('admin.pond-license.*') || Route::is('admin.pond-balam.create') || Route::is('admin.commercial.*') || Route::is('admin.commercial-balam.create'), 'menu-open') }}">
                    <x-utils.link class="nav-link" :active="activeClass(
                        Route::is('admin.agriculture.*') ||
                            Route::is('admin.agriculture-balam.create') ||
                            Route::is('admin.pond-license.*') ||
                            Route::is('admin.pond-balam.create') ||
                            Route::is('admin.commercial.*') ||
                            Route::is('admin.commercial-balam.create'),
                        'active',
                    )" icon="fa fa-id-card"
                        rightIcon="fas fa-angle-left right" :text="__('লাইসেন্স ব্যবস্থাপনা')">
                    </x-utils.link>

                    <ul class="nav nav-treeview">
                        @if (
                            $logged_in_user->hasAllAccess() ||
                                $logged_in_user->can('agriculture index') ||
                                $logged_in_user->can('agriculture edit') ||
                                $logged_in_user->can('agriculture create'))

                            <li
                                class="nav-item has-treeview {{ activeClass(Route::is('admin.agriculture.*') || Route::is('admin.agriculture-balam.create'), 'menu-open') }}">
                                <x-utils.link class="nav-link" :active="activeClass(
                                    Route::is('admin.agriculture.*') || Route::is('admin.agriculture-balam.create.'),
                                    'active',
                                )" href="#" icon="fas fa fa-tree"
                                    rightIcon="fas fa-angle-left right" :text="__('কৃষি লাইসেন্স')" />
                                <ul class="nav nav-treeview">
                                    @if ($logged_in_user->can('agriculture create'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.agriculture.create')" :active="activeClass(Route::is('admin.agriculture.create'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('কৃষি লাইসেন্স এন্ট্রি')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                    @if ($logged_in_user->can('agriculture index'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.agriculture.index')" :active="activeClass(Route::is('admin.agriculture.index'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('কৃষি লাইসেন্সের তালিকা')">
                                            </x-utils.link>
                                        </li>
                                    @endif

                                    {{-- <li class="nav-item">
                                        <x-utils.link class="nav-link" :href="route('admin.agriculture-balam.create')" :active="activeClass(Route::is('admin.agriculture-balam.create'), 'active')"
                                            icon="fas fa-long-arrow-alt-right" :text="__('কৃষি লাইসেন্স বালাম')">
                                        </x-utils.link>
                                    </li> --}}

                                </ul>
                            </li>
                        @endif

                        @if (
                            $logged_in_user->hasAllAccess() ||
                                $logged_in_user->can('commercial index') ||
                                $logged_in_user->can('commercial edit') ||
                                $logged_in_user->can('commercial create'))


                            <li
                                class="nav-item has-treeview {{ activeClass(Route::is('admin.commercial.*') || Route::is('admin.commercial-balam.create'), 'menu-open') }}">
                                <x-utils.link class="nav-link" :active="activeClass(
                                    Route::is('admin.commercial.*') || Route::is('admin.commercial-balam.create.'),
                                    'active',
                                )" href="#"
                                    icon="fas fa fa-building" rightIcon="fas fa-angle-left right" :text="__('বাণিজ্যিক লাইসেন্স')" />
                                <ul class="nav nav-treeview">
                                    @if ($logged_in_user->can('commercial create'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.commercial.create')" :active="activeClass(Route::is('admin.commercial.create'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('বাণিজ্যিক লাইসেন্স এন্ট্রি')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                    @if ($logged_in_user->can('commercial index'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.commercial.index')" :active="activeClass(Route::is('admin.commercial.index'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('বাণিজ্যিক লাইসেন্সের তালিকা')">
                                            </x-utils.link>
                                        </li>
                                    @endif

                                    {{-- <li class="nav-item">
                                        <x-utils.link class="nav-link" :href="route('admin.agriculture-balam.create')" :active="activeClass(Route::is('admin.agriculture-balam.create'), 'active')"
                                            icon="fas fa-long-arrow-alt-right" :text="__('কৃষি লাইসেন্স বালাম')">
                                        </x-utils.link>
                                    </li> --}}

                                </ul>
                            </li>
                        @endif
                        @if (
                            $logged_in_user->hasAllAccess() ||
                                $logged_in_user->can('pond-license index') ||
                                $logged_in_user->can('pond-license create') ||
                                $logged_in_user->can('pond-license edit'))

                            <li
                                class="nav-item has-treeview {{ activeClass(Route::is('admin.pond-license.*') || Route::is('admin.pond-balam.create'), 'menu-open') }}">
                                <x-utils.link class="nav-link" :active="activeClass(
                                    Route::is('admin.pond-license.*') || Route::is('admin.pond-balam.create.'),
                                    'active',
                                )" href="#" icon="fas fa fa-bank"
                                    rightIcon="fas fa-angle-left right" :text="__('জলাশয়ের লাইসেন্স')" />
                                <ul class="nav nav-treeview">
                                    @if ($logged_in_user->can('pond-license create'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.pond-license.create')" :active="activeClass(Route::is('admin.pond-license.create'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('জলাশয়ের লাইসেন্স এন্ট্রি')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                    @if ($logged_in_user->can('pond-license index'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.pond-license.index')" :active="activeClass(Route::is('admin.pond-license.index'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('জলাশয়ের লাইসেন্সের তালিকা')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if (
                            $logged_in_user->hasAllAccess() ||
                                $logged_in_user->can('agency index') ||
                                $logged_in_user->can('agency edit') ||
                                $logged_in_user->can('agency create'))
                            <li
                                class="nav-item has-treeview {{ activeClass(Route::is('admin.agency.*') || Route::is('admin.pond-balam.create'), 'menu-open') }}">
                                <x-utils.link class="nav-link" :active="activeClass(
                                    Route::is('admin.agency.*') || Route::is('admin.pond-balam.create.'),
                                    'active',
                                )" href="#" icon="fas fa fa-bank"
                                    rightIcon="fas fa-angle-left right" :text="__('সংস্থার লাইসেন্স')" />
                                <ul class="nav nav-treeview">
                                    @if ($logged_in_user->can('agency create'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.agency.create')" :active="activeClass(Route::is('admin.agency.create'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('সংস্থার লাইসেন্স এন্ট্রি')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                    @if ($logged_in_user->can('agency index'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.agency.index')" :active="activeClass(Route::is('admin.agency.index'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('সংস্থার লাইসেন্সের তালিকা')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>




                @if (
                    $logged_in_user->hasAllAccess() ||
                        $logged_in_user->can('masterplan index') ||
                        $logged_in_user->can('masterplan create') ||
                        $logged_in_user->can('masterplan edit'))

                    <li class="nav-item has-treeview {{ activeClass(Route::is('admin.masterplan.*'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(
                            Route::is('admin.masterplan.*') || Route::is('admin.masterplan-balam.create'),
                            'active',
                        )" href="#" icon="fas fa fa-bank"
                            rightIcon="fas fa-angle-left right" :text="__('মাস্টারপ্লান')" />
                        <ul class="nav nav-treeview">
                            @if ($logged_in_user->can('masterplan create'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.masterplan.create')" :active="activeClass(Route::is('admin.masterplan.create'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('মাস্টারপ্লান এন্ট্রি')">
                                    </x-utils.link>
                                </li>
                            @endif
                            @if ($logged_in_user->can('masterplan index'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.masterplan.index')" :active="activeClass(Route::is('admin.masterplan.index'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('মাস্টারপ্লান সমূহ')">
                                    </x-utils.link>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- <li class="nav-item has-treeview {{ activeClass(Route::is('admin.masterplan-plot.*'), 'menu-open') }}">
                    <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.masterplan-plot.*'), 'active')" href="#" icon="fas fa fa-bank" rightIcon="fas fa-angle-left right" :text="__('মাস্টারপ্লান প্লট')" />
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <x-utils.link class="nav-link" :href="route('admin.masterplan-plot.create')" :active="activeClass(Route::is('admin.masterplan-plot.create'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('মাস্টারপ্লান প্লট এন্ট্রি')">
                            </x-utils.link>
                        </li>
                        <li class="nav-item">
                            <x-utils.link class="nav-link" :href="route('admin.masterplan-plot.index')" :active="activeClass(Route::is('admin.masterplan-plot.index'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('মাস্টারপ্লান প্লট সমূহ')">
                            </x-utils.link>
                        </li>
                    </ul>
                </li> -->

                @if (
                    $logged_in_user->hasAllAccess() ||
                        $logged_in_user->can('all-license-fee create') ||
                        $logged_in_user->can('all-license-fee index') ||
                        $logged_in_user->can('all-license due'))


                    <li
                        class="nav-item has-treeview {{ activeClass(Route::is('admin.all_license_fees.*') || Route::is('admin.find.license'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(
                            Route::is('admin.all_license_fees.*') || Route::is('admin.find.license'),
                            'active',
                        )" href="#"
                            icon="fa-solid fa-money-bill-1-wave" rightIcon="fas fa-angle-left right"
                            :text="__('লাইসেন্স ফি')">
                        </x-utils.link>

                        <ul class="nav nav-treeview">
                            @if ($logged_in_user->can('all-license-fee create'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.all_license_fees.create')" :active="activeClass(Route::is('admin.all_license_fees.create'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('লাইসেন্স ফি আদায়')"></x-utils.link>
                                </li>
                            @endif
                            @if ($logged_in_user->can('all-license-fee index'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.all_license_fees.index')" :active="activeClass(Route::is('admin.all_license_fees.index'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('আদায়কৃত ফি’র তালিকা')"></x-utils.link>
                                </li>
                            @endif
                            @if ($logged_in_user->can('all-license due'))
                                <li class="nav-item">

                                    <x-utils.link class="nav-link" :href="route('admin.all.license.due')" :active="activeClass(Route::is('admin.all.license.due'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('বকেয়া লাইসেন্স ফি’র তালিকা')"></x-utils.link>
                                </li>
                            @endif
                            <!-- <li class="nav-item has-treeview {{ activeClass(Route::is('admin.agri-license-fees.*'), 'menu-open') }}">
                            <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.agri-license-fees.*'), 'active')" href="#" icon="fas fa fa-bank" rightIcon="fas fa-angle-left right" :text="__('কৃষি লাইসেন্স')" />
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.agri-license-fees.index')" :active="activeClass(Route::is('admin.agri-license-fees.index'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('আদায় কৃত লাইসেন্সে ফি')"></x-utils.link>
                                </li>
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.agri-license-fees.create')" :active="activeClass(Route::is('admin.agri-license-fees.create'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('লাইসেন্স ফি আদায়')"></x-utils.link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{ activeClass(Route::is('admin.commercial-fees.*') || Route::is('admin.commercial-balam.create'), 'menu-open') }}">
                            <x-utils.link class="nav-link" :active="activeClass(
                                Route::is('admin.commercial-fees.*') || Route::is('admin.commercial-balam.create.'),
                                'active',
                            )" href="#" icon="fas fa fa-bank" rightIcon="fas fa-angle-left right" :text="__('বাণিজ্যিক লাইসেন্স')" />
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.commercial-fees.index')" :active="activeClass(Route::is('admin.commercial-fees.index'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('আদায় কৃত লাইসেন্সে ফি')"></x-utils.link>
                                </li>
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.commercial-fees.create')" :active="activeClass(Route::is('admin.commercial-fees.create'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('লাইসেন্স ফি আদায়')"></x-utils.link>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item has-treeview {{ activeClass(Route::is('admin.pond-license-fees.*') || Route::is('admin.pond-balam.create.'), 'menu-open') }}">
                            <x-utils.link class="nav-link" :active="activeClass(
                                Route::is('admin.pond-license-fees.*') || Route::is('admin.pond-balam.create.'),
                                'active',
                            )" href="#" icon="fas fa fa-bank" rightIcon="fas fa-angle-left right" :text="__('জলাশয় লাইসেন্স')" />
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.pond-license-fees.index')" :active="activeClass(Route::is('admin.pond-license-fees.index'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('আদায় কৃত লাইসেন্সে ফি')"></x-utils.link>
                                </li>
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.pond-license-fees.create')" :active="activeClass(Route::is('admin.pond-license-fees.create'), 'active')" icon="fas fa-long-arrow-alt-right" :text="__('লাইসেন্স ফি আদায়')"></x-utils.link>
                                </li>
                            </ul>
                        </li> -->

                        </ul>
                    </li>
                @endif

                @if (
                    $logged_in_user->hasAllAccess() ||
                        $logged_in_user->can('commercial-tender create') ||
                        $logged_in_user->can('commercial-tender index') ||
                        $logged_in_user->can('pond-tender create') ||
                        $logged_in_user->can('pond-tender index'))
                    <li
                        class="nav-item has-treeview {{ activeClass(Route::is('admin.commercial-tender.*'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.commercial-tender.*'), 'active')" icon="far fa-file-alt"
                            rightIcon="fas fa-angle-left right" :text="__('দরপত্র ব্যবস্থাপনা')">
                        </x-utils.link>

                        <ul class="nav nav-treeview">

                            <li
                                class="nav-item has-treeview {{ activeClass(Route::is('admin.commercial-tender.*'), 'menu-open') }}">
                                <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.commercial-tender.*'), 'active')" href="#"
                                    icon="fas fa fa-bank" rightIcon="fas fa-angle-left right" :text="__('বাণিজ্যিক দরপত্র')" />
                                <ul class="nav nav-treeview">
                                    @if ($logged_in_user->can('commercial-tender create'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.commercial-tender.create')" :active="activeClass(
                                                Route::is('admin.commercial-tender.create'),
                                                'active',
                                            )"
                                                icon="fas fa-long-arrow-alt-right" :text="__('বাণিজ্যিক দরপত্র এন্ট্রি')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                    @if ($logged_in_user->can('commercial-tender index'))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.commercial-tender.index')" :active="activeClass(
                                                Route::is('admin.commercial-tender.index'),
                                                'active',
                                            )"
                                                icon="fas fa-long-arrow-alt-right" :text="__('বাণিজ্যিক দরপত্র সমূহ')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            @if (
                                $logged_in_user->hasAllAccess() ||
                                    $logged_in_user->can('pond-tender create') ||
                                    $logged_in_user->can('pond-tender index'))
                                <li
                                    class="nav-item has-treeview {{ activeClass(Route::is('admin.commercial.*') || Route::is('admin.commercial-balam.create'), 'menu-open') }}">
                                    <x-utils.link class="nav-link" :active="activeClass(
                                        Route::is('admin.commercial.*') || Route::is('admin.commercial-balam.create.'),
                                        'active',
                                    )" href="#"
                                        icon="fas fa fa-bank" rightIcon="fas fa-angle-left right"
                                        :text="__('জলাশয়ের দরপত্র')" />
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.commercial.create')" :active="activeClass(Route::is('admin.commercial.create'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('বাণিজ্যিক দরপত্র এন্ট্রি')">
                                            </x-utils.link>
                                        </li>
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.commercial.index')" :active="activeClass(Route::is('admin.commercial.index'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('বাণিজ্যিক দরপত্র সমূহ')">
                                            </x-utils.link>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if ($logged_in_user->hasAllAccess())
                    <li class="nav-item has-treeview {{ activeClass(Route::is('admin.payment.*'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.payment.*'), 'active')" href="#" icon="fa fa-address-book"
                            rightIcon="fas fa-angle-left right" :text="__('পেমেন্ট')">
                        </x-utils.link>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.payment.create')" :active="activeClass(Route::is('admin.payment.create'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('পেমেন্ট সার্চ')"></x-utils.link>
                            </li>
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.payment.index')" :active="activeClass(Route::is('admin.payment.index'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('পেমেন্ট তালিকা')"></x-utils.link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ activeClass(Route::is('admin.inventory.*'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.inventory.*'), 'active')" href="#" icon="fa fa-address-book"
                            rightIcon="fas fa-angle-left right" :text="__('ইনভেনটরী সম্পর্কিত তথ্য')">
                        </x-utils.link>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.inventory.index')" :active="activeClass(Route::is('admin.inventory.index'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('ইনভেনটরী সমূহ')"></x-utils.link>
                            </li>
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.inventory.create')" :active="activeClass(Route::is('admin.inventory.create'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('ইনভেনটরী তথ্য এন্ট্রি')"></x-utils.link>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (
                    $logged_in_user->hasAllAccess() ||
                        $logged_in_user->can('district index') ||
                        $logged_in_user->can('district create') ||
                        $logged_in_user->can('upazilla index') ||
                        $logged_in_user->can('upazilla create') ||
                        $logged_in_user->can('station index') ||
                        $logged_in_user->can('station create') ||
                        $logged_in_user->can('mouja index') ||
                        $logged_in_user->can('mouja create'))
                    <li
                        class="nav-item has-treeview {{ activeClass(Route::is('admin.district.*') || Route::is('admin.upazilla.*') || Route::is('admin.site_settings.index') || Route::is('admin.mouja.*') || Route::is('admin.station.*'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(
                            Route::is('admin.district.*') ||
                                Route::is('admin.upazilla.*') ||
                                Route::is('admin.station.*') ||
                                Route::is('admin.mouja.*') ||
                                Route::is('admin.site_settings.index'),
                            'active',
                        )" href="#" icon="fas fa-tools"
                            rightIcon="fas fa-angle-left right" :text="__('সাধারন সেটিংস')">
                        </x-utils.link>

                        <ul class="nav nav-treeview">
                            @if ($logged_in_user->can('district index'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="url('admin/district')" :active="activeClass(Route::is('admin.district.index'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('জেলা')"></x-utils.link>
                                </li>
                            @endif
                            @if ($logged_in_user->can('upazilla index'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.upazilla.index')" :active="activeClass(Route::is('admin.upazilla.index'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('উপজেলা')"></x-utils.link>
                                </li>
                            @endif
                            @if ($logged_in_user->can('station index'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.station.index')" :active="activeClass(Route::is('admin.station.index'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('স্টেশন')"></x-utils.link>
                                </li>
                            @endif
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.mouja.index')" :active="activeClass(Route::is('admin.mouja.index'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('মৌজা')"></x-utils.link>
                            </li>
                            @if ($logged_in_user->hasAllAccess())
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.site_settings.index')" :active="activeClass(Route::is('admin.site_settings.index'), 'active')"
                                        icon="fas fa-solid fa-minus" :text="__('Site settings')">
                                    </x-utils.link>

                                </li>
                            @endif
                        </ul>
                    </li>


                @endif



                @if (
                    $logged_in_user->hasAllAccess() ||
                        $logged_in_user->can('case create') ||
                        $logged_in_user->can('case edit') ||
                        $logged_in_user->can('case index'))

                    <li class="nav-item has-treeview {{ activeClass(Route::is('admin.case.*'), 'menu-open') }}">
                        <x-utils.link class="nav-link" :active="activeClass(Route::is('admin.case.*'), 'active')" href="#" icon="fa fa-address-book"
                            rightIcon="fas fa-angle-left right" :text="__('মামলার ব্যবস্থাপনা')">
                        </x-utils.link>

                        <ul class="nav nav-treeview">
                            @if ($logged_in_user->can('case create'))
                                <li class="nav-item">
                                    <x-utils.link class="nav-link" :href="route('admin.case.create')" :active="activeClass(Route::is('admin.case.create'), 'active')"
                                        icon="fas fa-long-arrow-alt-right" :text="__('মামলা এন্ট্রি')"></x-utils.link>
                                </li>
                            @endif
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.case.index')" :active="activeClass(Route::is('admin.case.index'), 'active')"
                                    icon="fas fa-long-arrow-alt-right" :text="__('মামলা তালিকা')"></x-utils.link>
                            </li>
                        </ul>
                    </li>
                @endif

                <i class="fa-solid "></i>
                @if (
                    $logged_in_user->hasAllAccess() ||
                        ($logged_in_user->can('admin.access.user.list') ||
                            $logged_in_user->can('admin.access.user.deactivate') ||
                            $logged_in_user->can('admin.access.user.reactivate') ||
                            $logged_in_user->can('admin.access.user.clear-session') ||
                            $logged_in_user->can('admin.access.user.impersonate') ||
                            $logged_in_user->can('admin.access.user.change-password')))
                    <li class="nav-header">@lang('System')</li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="icon-settings"></i>
                            <p>@lang('Settings')
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('admin.dashboard')" :active="activeClass(Route::is('admin.dashboard'), 'active')"
                                    icon="fas fa-solid fa-minus" :text="__('Initial')">
                                </x-utils.link>
                            </li>

                            <li
                                class="nav-item has-treeview {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'menu-open') }}">
                                <x-utils.link class="nav-link" href="#" icon="icon-users"
                                    rightIcon="fa fa-angle-left right" :text="__('Access')"></x-utils.link>
                                <ul class="nav nav-treeview">
                                    <!-- <li class="nav-item">
                                        <x-utils.link class="nav-link" :href="url('admin.permission-control.index')" :active="activeClass(Route::is('admin.permission-control.*'), 'active')"
                                            icon="fas fas fa-long-arrow-alt-right" :text="__('Control Permission')">
                                        </x-utils.link>
                                    </li> -->
                                    <li class="nav-item">
                                        <x-utils.link class="nav-link" :href="route('admin.designation.index')" :active="activeClass(Route::is('admin.designation.*'), 'active')"
                                            icon="fas fas fa-long-arrow-alt-right" :text="__('Designation')">
                                        </x-utils.link>
                                    </li>
                                    @if (
                                        $logged_in_user->hasAllAccess() ||
                                            ($logged_in_user->can('admin.access.user.list') ||
                                                $logged_in_user->can('admin.access.user.deactivate') ||
                                                $logged_in_user->can('admin.access.user.reactivate') ||
                                                $logged_in_user->can('admin.access.user.clear-session') ||
                                                $logged_in_user->can('admin.access.user.impersonate') ||
                                                $logged_in_user->can('admin.access.user.change-password')))
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.auth.user.index')" :active="activeClass(Route::is('admin.auth.user.*'), 'active')"
                                                icon="fas fa-long-arrow-alt-right" :text="__('User Management')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                    @if ($logged_in_user->hasAllAccess())
                                        <li class="nav-item">
                                            <x-utils.link class="nav-link" :href="route('admin.auth.role.index')"
                                                icon="fas fa-long-arrow-alt-right" :active="activeClass(Route::is('admin.auth.role.*'), 'active')"
                                                :text="__('Role Management')">
                                            </x-utils.link>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($logged_in_user->hasAllAccess())
                    <li class="nav-item has-treeview">
                        <x-utils.link class="nav-link" href="#" icon="fa fa-list-ul"
                            rightIcon="fa fa-angle-left right" :text="__('Logs')"></x-utils.link>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('log-viewer::dashboard')" icon="fas fa-long-arrow-alt-right"
                                    :text="__('Dashboard')">
                                </x-utils.link>
                            </li>
                            <li class="nav-item">
                                <x-utils.link class="nav-link" :href="route('log-viewer::logs.list')" icon="fas fa-long-arrow-alt-right"
                                    :text="__('Logs')"></x-utils.link>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav> <!-- /.sidebar-menu -->
    </div> <!-- /.sidebar -->
</aside>
