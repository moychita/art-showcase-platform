@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-16 px-4 sm:px-6 lg:px-8 text-center">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Akun Sedang Ditinjau</h1>
        <p class="text-gray-600 mb-6">
            Terima kasih telah mendaftar sebagai Curator. Tim Admin kami sedang meninjau permohonan Anda.
            Kami akan mengirimkan pemberitahuan segera setelah akun Anda disetujui.
        </p>
        <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection

