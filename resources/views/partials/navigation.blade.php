<header class="bg-black" x-data="{ menu_open: false }">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Indian Creek Baptist Camp</span>
                <img class="h-12 w-auto" src="{{ asset('camp-logo-white.png') }}" alt="Indian Creek Baptist Camp">
            </a>
        </div>
        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-white" @click="menu_open = !menu_open">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12 mr-12">
            <div class="relative" x-data="{show: false}">
                <button type="button" class="flex items-center gap-x-1 text-xl/6 font-semibold text-white font-heading" aria-expanded="false" @click="show = !show">
                    Camps & Events
                    <svg class="size-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="absolute -left-8 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5" x-show="show == true" @click.away="show = false">
                    <div class="p-4">
                        @include('partials.navigation-dropdown', [
                            'url' => '/camp-page',
                            'title' => '2025 Summer Camps',
                            'icon' => 'calendar-week',
                            'subtitle' => 'See what is available in Summer 2025'
                        ])
                        @foreach($campTypes as $camptype)
                            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-secondary">
                                <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <x-dynamic-component :component="$camptype->icon" class="size-6 text-gray-600 group-hover:text-accent" />
                                </div>
                                <div class="flex-auto">
                                    <a href="/camp-page?type={{$camptype->id}}" class="block font-semibold text-gray-900 group-hover:text-white">
                                        {{ $camptype->name }}
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600 group-hover:text-base">{{$camptype->subtitle}}</p>
                                </div>
                            </div>

                        @endforeach
                        @foreach($campPages as $page)
                            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-secondary">
                                <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <x-dynamic-component :component="$page->icon" class="size-6 text-gray-600 group-hover:text-accent" />
                                </div>
                                <div class="flex-auto">
                                    <a href="/page/{{$page->slug}}" class="block font-semibold text-gray-900 group-hover:text-white">
                                        {{ $page->title }}
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600 group-hover:text-base">{{$page->subtitle}}</p>
                                </div>
                            </div>
                        @endforeach

                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Other Events',
                            'icon' => 'calendar-event',
                            'subtitle' => 'Seasonal events'
                        ])
                    </div>
                </div>
            </div>
            <div class="relative" x-data="{show: false}">
                <button type="button" class="flex items-center gap-x-1 text-xl/6 font-semibold text-white font-heading" aria-expanded="false" @click="show = !show">
                    About Us
                    <svg class="size-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="absolute -left-24 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5" x-show="show == true" @click.away="show = false">
                    <div class="p-4">
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Our Staff',
                            'icon' => 'users',
                            'subtitle' => 'Meet our leadership team'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Our Beliefs',
                            'icon' => 'book',
                            'subtitle' => 'Learn what we believe'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Our History',
                            'icon' => 'clock-hour-3',
                            'subtitle' => '30 years of serving Christ'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Work at ICBC',
                            'icon' => 'file-description',
                            'subtitle' => 'Sign up to become a camp counselor'
                        ])
                    </div>
                </div>
            </div>
            <div class="relative" x-data="{show: false}">
                <button type="button" class="flex items-center gap-x-1 text-xl/6 font-semibold text-white font-heading" aria-expanded="false" @click="show = !show">
                    Resources
                    <svg class="size-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div class="absolute -right-6 top-full z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5" x-show="show == true" @click.away="show = false">
                    <div class="p-4">
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Camp Conduct Guide',
                            'icon' => 'list-check',
                            'subtitle' => 'Rules for campers'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Directions and Location',
                            'icon' => 'directions',
                            'subtitle' => 'Where we are'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Camp Rental Guide',
                            'icon' => 'license',
                            'subtitle' => 'Essential info for camp rental weeks'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'Camp Counselor Guide',
                            'icon' => 'file-description',
                            'subtitle' => 'Handbook for camp counselors'
                        ])
                        @include('partials.navigation-dropdown', [
                            'url' => '#',
                            'title' => 'FAQs',
                            'icon' => 'help-octagon',
                            'subtitle' => 'Frequently Asked Questions'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true" x-show="menu_open == true">
        <div class="fixed inset-0 z-20"></div>
        <div class="fixed inset-y-0 right-0 z-30 w-full overflow-y-auto bg-black px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10" @click.away="menu_open = false">
            <div class="flex items-center justify-between sm:justify-end">
                <a href="#" class="-m-1.5 p-1.5 sm:hidden">
                    <span class="sr-only">Indian Creek Baptist Camp</span>
                    <img class="h-8 w-auto" src="{{ asset('camp-logo-white.png') }}" alt="Indian Creek Baptist Camp">
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-100" @click="menu_open = false">
                    <span class="sr-only">Close menu</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <div class="-mx-3" x-data="{open: false}">
                            <button type="button" class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base/7 font-semibold text-gray-100 hover:bg-secondary" aria-controls="disclosure-1" aria-expanded="false" @click="open = !open">
                                Camps & Events
                                <svg class="size-5 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2" id="disclosure-1" x-show="open == true">
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">2025 Summer Camps</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Teen Camp</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Junior Camp</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Combo Camp</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Camp Rentals</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Other Events</a>
                            </div>
                        </div>
                        <div class="-mx-3" x-data="{open: false}">
                            <button type="button" class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base/7 font-semibold text-gray-100 hover:bg-secondary" aria-controls="disclosure-1" aria-expanded="false" @click="open = !open">
                                About Us
                                <svg class="size-5 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2" id="disclosure-1" x-show="open == true">
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Our Staff</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Our Beliefs</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Our History</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Work at ICBC</a>
                            </div>
                        </div>
                        <div class="-mx-3" x-data="{open: false}">
                            <button type="button" class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base/7 font-semibold text-gray-100 hover:bg-secondary" aria-controls="disclosure-1" aria-expanded="false" @click="open = !open">
                                Resources
                                <svg class="size-5 flex-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2" id="disclosure-1" x-show="open == true">
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Camp Conduct Guide</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Directions</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Camp Rental Guide</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">Camp Counselor Guide</a>
                                <a href="#" class="block rounded-lg py-2 pl-6 pr-3 text-sm/7 font-semibold text-gray-100 hover:bg-secondary">FAQs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
