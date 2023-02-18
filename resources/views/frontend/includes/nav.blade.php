<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <nav class="navbar navbar-expand-md navbar-light bg-darkgreen">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <x-utils.bsLink :href="route('frontend.index')" :active="activeClass(Route::is('frontend.index'))" :text="__('Home')" class="nav-link" />
                        </li>
                        @guest
                            <!-- <li class="nav-item">
                                <x-utils.bsLink :href="route('frontend.auth.register')" :active="activeClass(Route::is('frontend.auth.register'))" :text="__('Sign up')" class="nav-link" />
                            </li> -->

                            <li class="nav-item">
                                <x-utils.bsLink :href="route('frontend.index')" :active="activeClass(Route::is('frontend.index'))" :text="__('Commercial Tender')" class="nav-link" />
                            </li>

                            <li class="nav-item">
                                <x-utils.bsLink :href="route('frontend.index')" :active="activeClass(Route::is('frontend.index'))" :text="__('Pond Tender')" class="nav-link" />
                            </li>

                            <li class="nav-item">
                                <x-utils.bsLink :href="route('frontend.auth.login')" :active="activeClass(Route::is('frontend.auth.login'))" :text="__('Login')" class="nav-link" />
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <x-utils.bsLink href="#" id="navbarDropdown" class="nav-link dropdown-toggle"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <x-slot name="text">
                                        <img class="rounded-circle" style="max-height: 20px"
                                            src="{{ $logged_in_user->avatar }}" />
                                        {{ $logged_in_user->name }} <span class="caret"></span>
                                    </x-slot>
                                </x-utils.bsLink>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if ($logged_in_user->isAdmin())
                                        <x-utils.bsLink :href="route('admin.dashboard')" :text="__('Administration')" class="dropdown-item" />
                                    @endif

                                    @if ($logged_in_user->isUser())
                                        <x-utils.bsLink :href="route('frontend.user.dashboard')" :active="activeClass(Route::is('frontend.user.dashboard'))" :text="__('Dashboard')"
                                            class="dropdown-item" />
                                    @endif

                                    <x-utils.bsLink :href="route('frontend.user.account')" :active="activeClass(Route::is('frontend.user.account'))" :text="__('My Account')"
                                        class="dropdown-item" />

                                    <x-utils.bsLink :text="__('Logout')" class="dropdown-item"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <x-slot name="text">
                                            @lang('Logout')
                                            <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
                                        </x-slot>
                                    </x-utils.bsLink>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif
