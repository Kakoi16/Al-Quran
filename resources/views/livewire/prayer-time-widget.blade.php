{{-- components/prayer-time-widget.blade.php --}}
<div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-md mx-auto">
    <div class="p-6 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Jadwal Sholat</h2>
                @if(!$errors->any() && !session()->has('error'))
                <p class="text-sm text-indigo-200 opacity-90">{{ $city }}, {{ $country }}</p>
                @endif
            </div>
            <div class="text-right">
                <p class="font-semibold">{{ $date }}</p>
            </div>
        </div>
    </div>

    <div class="p-4 bg-slate-50 border-b border-slate-200">
        <button wire:click="$toggle('showLocationForm')" class="w-full text-sm text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2 justify-center py-2 rounded-lg hover:bg-indigo-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
            Ganti Lokasi
        </button>

        @if ($showLocationForm)
        <div class="mt-4 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="country" class="block text-xs font-medium text-slate-600 mb-1">Negara</label>
                    <select wire:model="inputCountry" wire:change="loadCities" id="country" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Pilih Negara</option>
                        @foreach($countries as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="city" class="block text-xs font-medium text-slate-600 mb-1">Kota</label>
                    <select wire:model.defer="inputCity" id="city" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Pilih Kota</option>
                        @foreach($cities as $ct)
                        <option value="{{ $ct }}">{{ $ct }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-2">
                <div wire:loading wire:target="loadCities, updateLocation" class="text-sm text-slate-500 animate-pulse">
                    Memuat...
                </div>
                <button wire:click="updateLocation" wire:loading.attr="disabled" class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors">
                    Cari Jadwal
                </button>
            </div>
        </div>
        @endif
    </div>

    @if (session()->has('error'))
    <div class="p-4 bg-red-100 text-red-800 text-sm border-b border-red-200">
        {{ session('error') }}
    </div>
    @endif

    <div class="divide-y divide-slate-100">
        @if (!empty($timings))
        @php
        // Ikon disederhanakan dan diseragamkan warnanya
        $prayerIcons = [
            'Fajr'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a7 7 0 1 0 10 10" /><path d="M12 2A7 7 0 1 0 2 12" /><path d="M2 12h20" /></svg>',
            'Dhuhr'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4" /><path d="M12 2v2" /><path d="M12 20v2" /><path d="m4.93 4.93 1.41 1.41" /><path d="m17.66 17.66 1.41 1.41" /><path d="M2 12h2" /><path d="M20 12h2" /><path d="m6.34 17.66-1.41 1.41" /><path d="m19.07 4.93-1.41 1.41" /></svg>',
            'Asr'     => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" /><path d="M12 4v1" /><path d="M12 19v1" /><path d="M4 12h1" /><path d="M18 12h1" /><path d="m19.071 19.071-1.414-1.414" /><path d="m6.343 6.343-1.414-1.414" /></svg>',
            'Maghrib' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" /></svg>',
            'Isha'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6.364 6.364 0 0 0 9 9 9 9 0 1 1-9-9Z" /><path d="M19 3v4h-4" /></svg>',
        ];
        @endphp

        @foreach (['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'] as $prayer)
        @if (isset($timings[$prayer]))
        <div class="px-6 py-4 flex items-center justify-between transition-colors duration-300 @if($prayer === $nextPrayerName) bg-indigo-50/70 @endif">
            <div class="flex items-center gap-4">
                <div class="text-slate-400 @if($prayer === $nextPrayerName) text-indigo-600 @endif">
                    {!! $prayerIcons[$prayer] !!}
                </div>
                <span class="text-lg font-medium text-slate-700">{{ $prayer }}</span>
            </div>
            <div class="flex items-center gap-4">
                @if($prayer === $nextPrayerName)
                <span class="hidden sm:inline-block text-xs font-bold bg-indigo-600 text-white px-3 py-1 rounded-full uppercase tracking-wider">BERIKUTNYA</span>
                @endif
                <span class="text-xl font-mono font-bold text-slate-800 @if($prayer === $nextPrayerName) text-indigo-600 @endif">{{ $timings[$prayer] }}</span>
            </div>
        </div>
        @endif
        @endforeach
        @else
        <p class="p-6 text-center text-slate-500">Silakan pilih lokasi untuk menampilkan jadwal.</p>
        @endif
    </div>
</div>