<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Exception;

class PrayerTimeWidget extends Component
{
    public $timings;
    public $date;
    public $city = 'Cikampek';
    public $country = 'Indonesia';
    public $nextPrayerName = '';

    public $inputCity = 'Cikampek';
    public $inputCountry = 'Indonesia';
    public $showLocationForm = false;

    // Properti baru untuk menampung daftar pilihan
    public $countries = [];
    public $cities = [];

 public function mount()
{
    $this->loadCountries();

    // Jika inputCountry sudah ada saat mount, langsung load cities
    if (!empty($this->inputCountry)) {
        $this->loadCities();
    }

    $this->loadPrayerTimes();
}


    // Method baru untuk memuat daftar negara
public function loadCountries()
{
    try {
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');
        if ($response->successful()) {
            $this->countries = collect($response->json()['data'])
                ->pluck('name')
                ->sort()
                ->all();
        }
    } catch (Exception $e) {
        $this->countries = ['Indonesia', 'Malaysia', 'Japan', 'Saudi Arabia']; // fallback
    }
}

public $autoLoadCities = false;

    // Method baru untuk memuat daftar kota berdasarkan negara yang dipilih
public function loadCities()
{
    $this->cities = []; // Kosongkan dulu
    if (empty($this->inputCountry)) {
        session()->flash('error', 'Pilih negara terlebih dahulu.');
        return;
    }

    try {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', [
            'country' => $this->inputCountry
        ]);

        if ($response->successful() && !empty($response->json()['data'])) {
            $this->cities = collect($response->json()['data'])->sort()->all();
        } else {
            session()->flash('error', 'Daftar kota tidak ditemukan.');
        }
    } catch (Exception $e) {
        session()->flash('error', 'Gagal memuat daftar kota.');
    }
}


public function updatedInputCity($value)
{
    if (!empty($value)) {
        $this->city = $value;
        $this->country = $this->inputCountry;
        $this->loadPrayerTimes();
    }
}

    // Method ini akan terpanggil otomatis setiap kali $inputCountry berubah
public function updatedInputCountry($value)
{
    $this->inputCity = ''; // Reset kota saat negara berubah
    $this->cities = [];    // Kosongkan daftar kota

    if (!empty($value)) {
        try {
            $response = Http::post('https://countriesnow.space/api/v0.1/countries/cities', [
                'country' => $value
            ]);

            if ($response->successful() && !empty($response->json()['data'])) {
                $this->cities = collect($response->json()['data'])->sort()->values()->all();
            } else {
                session()->flash('error', 'Daftar kota tidak ditemukan.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat daftar kota.');
        }
    }
}

public function updateLocation()
{
    $this->validate([
        'inputCity' => 'required|string',
        'inputCountry' => 'required|string',
    ]);

    $this->city = $this->inputCity;
    $this->country = $this->inputCountry;
    $this->loadPrayerTimes();
    $this->showLocationForm = false;
}


    
    // Sisa method (loadPrayerTimes, findNextPrayer, render) tidak berubah
    public function loadPrayerTimes()
    {
        session()->forget('error');
        try {
            $response = Http::get('http://api.aladhan.com/v1/timingsByCity', [
                'city' => $this->city,
                'country' => $this->country,
                'method' => 4
            ]);
            if ($response->successful() && !empty($response->json()['data'])) {
                $this->timings = $response->json()['data']['timings'];
                $this->date = Carbon::parse($response->json()['data']['date']['readable'], 'Asia/Jakarta')->isoFormat('dddd, D MMMM YYYY');
                $this->findNextPrayer();
            } else {
                throw new Exception('Lokasi tidak ditemukan.');
            }
        } catch (Exception $e) {
            $this->timings = [];
            session()->flash('error', 'Lokasi tidak ditemukan. Coba pilih lokasi lain.');
        }
    }

    public function findNextPrayer()
    {
        $tz = 'Asia/Jakarta';
        $now = Carbon::now($tz);
        $prayerOrder = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
        foreach ($prayerOrder as $prayer) {
            if (isset($this->timings[$prayer])) {
                $prayerTime = Carbon::parse($this->timings[$prayer], $tz);
                if ($prayerTime->isAfter($now)) {
                    $this->nextPrayerName = $prayer;
                    return;
                }
            }
        }
        $this->nextPrayerName = 'Fajr';
    }

    public function render()
    {
        return view('livewire.prayer-time-widget');
    }
}