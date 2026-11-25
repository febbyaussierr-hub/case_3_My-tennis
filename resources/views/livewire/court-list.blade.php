<div>

    <!-- SEARCH AND FILTER -->
    <div class="bg-white rounded-2xl border border-gray-200 p-5 md:p-6 mb-10 shadow-sm">

        <!-- SEARCH INPUT -->
        <div class="mb-5">

            <flux:input
                wire:model.live.debounce.300ms="search"
                label="Search Location or Court"
                icon="magnifying-glass"
                placeholder="Contoh: Palembang, Court A..."
                clearable
            />

        </div>

        <!-- FILTER -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

            <!-- CITY FILTER -->
            <flux:select wire:model.live="city" label="Location">

                <flux:select.option value="">
                    All Cities
                </flux:select.option>

                @foreach($cities as $item)
                    <flux:select.option value="{{ $item }}">
                        {{ $item }}
                    </flux:select.option>
                @endforeach

            </flux:select>

            <!-- PRICE FILTER -->
            <flux:select wire:model.live="price" label="Price Range">

                <flux:select.option value="">
                    All Prices
                </flux:select.option>

                <flux:select.option value="low">
                    Up to Rp100.000
                </flux:select.option>

                <flux:select.option value="medium">
                    Rp100.001 - Rp150.000
                </flux:select.option>

                <flux:select.option value="high">
                    Above Rp150.000
                </flux:select.option>

            </flux:select>

            <!-- SORT FILTER -->
            <flux:select wire:model.live="sort" label="Sort By">

                <flux:select.option value="latest">
                    Latest Courts
                </flux:select.option>

                <flux:select.option value="lowest">
                    Lowest Price
                </flux:select.option>

                <flux:select.option value="highest">
                    Highest Price
                </flux:select.option>

            </flux:select>

            <!-- RESET BUTTON -->
            <flux:button
                type="button"
                wire:click="resetFilters"
                icon="arrow-path"
                class="w-full">

                Reset Filters

            </flux:button>

        </div>

    </div>

    <!-- AVAILABLE COURTS -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">

        <div>

            <h2 class="text-2xl font-bold text-[#35432F]">
                Available Courts
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Pilih lapangan dan mulai permainanmu.
            </p>

        </div>

        <div class="bg-[#E8EDE3] text-[#536B50] px-4 py-2 rounded-full text-sm font-semibold">

            {{ $courts->count() }} Courts Found

        </div>

    </div>

    <!-- LOADING INDICATOR -->
    <div wire:loading class="w-full mb-5">

        <div class="flex items-center gap-3 text-[#536B50] text-sm">

            <svg class="animate-spin w-5 h-5"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24">

                <circle class="opacity-25"
                        cx="12" cy="12" r="10"
                        stroke="currentColor"
                        stroke-width="4"/>

                <path class="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>

            </svg>

            Searching courts...

        </div>

    </div>

    <!-- COURT LIST -->
    <div wire:loading.class="opacity-50"
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 transition-opacity">

        @forelse($courts as $court)

            <div wire:key="court-{{ $court->id }}"
                 class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition-shadow">

                <!-- COURT IMAGE -->
                @if($court->image)

                    <img
                        src="{{ asset('storage/' . $court->image) }}"
                        alt="{{ $court->name }}"
                        loading="lazy"
                        class="w-full h-56 object-cover">

                @else

                    <div class="w-full h-56 bg-[#687653] text-white flex flex-col items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 100 100"
                             class="w-16 h-16 mb-4">

                            <circle cx="50" cy="50" r="44"
                                    fill="#D9F581"
                                    stroke="white"
                                    stroke-width="3"/>

                            <path d="M26 13 Q66 50 26 87"
                                  fill="none"
                                  stroke="white"
                                  stroke-width="4"/>

                            <path d="M74 13 Q34 50 74 87"
                                  fill="none"
                                  stroke="white"
                                  stroke-width="4"/>

                        </svg>

                        <p class="text-sm text-white/80">
                            No Court Image
                        </p>

                    </div>

                @endif

                <!-- COURT INFORMATION -->
                <div class="p-6">

                    <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">

                        <span class="w-2 h-2 bg-green-600 rounded-full"></span>

                        Active

                    </span>

                    <h3 class="text-xl font-bold text-[#35432F] mt-4">

                        {{ $court->name }}

                    </h3>

                    <p class="text-gray-500 text-sm mt-2">

                        {{ $court->venue_name }}

                    </p>

                    <!-- LOCATION -->
                    <div class="flex items-center gap-2 text-sm text-gray-600 mt-3">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="1.8"
                             class="w-5 h-5 shrink-0 text-[#687653]">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1116 0z"/>

                            <circle cx="12" cy="10" r="2.5"/>

                        </svg>

                        <span>
                            {{ $court->city }}, {{ $court->province }}
                        </span>

                    </div>

                    <!-- PRICE -->
                    <div class="border-t border-gray-100 mt-5 pt-5">

                        <p class="text-sm text-gray-400">
                            Price per hour
                        </p>

                        <p class="text-2xl font-bold text-[#536B50] mt-1">

                            Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}

                        </p>

                    </div>

                    <!-- BOOKING BUTTON -->
                    <a href="{{ route('booking.show', $court->id) }}"
                       class="block text-center bg-[#536B50] hover:bg-[#40563E] text-white py-3 rounded-lg mt-6 font-semibold transition-colors">

                        BOOK NOW

                    </a>

                </div>

            </div>

        @empty

            <!-- EMPTY STATE -->
            <div class="col-span-full bg-white rounded-2xl border border-gray-200 p-10 text-center">

                <div class="w-16 h-16 bg-[#E8EDE3] rounded-full flex items-center justify-center mx-auto mb-5">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.5"
                         class="w-8 h-8 text-[#536B50]">

                        <circle cx="10.5" cy="10.5" r="6.5"/>

                        <path stroke-linecap="round"
                              d="m16 16 5 5"/>

                    </svg>

                </div>

                <h3 class="text-xl font-bold text-[#35432F]">

                    No Courts Found

                </h3>

                <p class="text-gray-500 mt-2 mb-5">

                    Coba gunakan kata kunci atau filter lainnya.

                </p>

                <flux:button
                    type="button"
                    wire:click="resetFilters"
                    icon="arrow-path">

                    Reset Filters

                </flux:button>

            </div>

        @endforelse

    </div>

</div>
