{{-- pages/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    @include('components.navbar')

    <main class="min-h-screen bg-slate-100/80 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            @livewire('prayer-time-widget')
        </div>
    </main>
@endsection

@push('scripts')
{{-- Script untuk dropdown kota tetap di sini, pastikan tidak ada duplikasi --}}
<script>
    window.addEventListener('updateDropdownCity', event => {
        const cityDropdown = document.getElementById('city');
        if (cityDropdown) {
            cityDropdown.value = event.detail.city;
            cityDropdown.dispatchEvent(new Event('change')); // Memicu update Livewire
        }
    });
</script>
@endpush