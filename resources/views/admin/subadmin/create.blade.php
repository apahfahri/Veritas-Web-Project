@extends('layouts.admin')
@section('page-title', 'Tambah Subadmin')
@section('page-subtitle', 'Tambahkan akun subadmin baru')

@section('content')

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.subadmin.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
            <input type="text" name="username" value="{{ old('username') }}" required
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#7d2ae7] focus:border-[#7d2ae7]">
            @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#7d2ae7] focus:border-[#7d2ae7]">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#7d2ae7] focus:border-[#7d2ae7]">
            <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter.</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp</label>
            <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#7d2ae7] focus:border-[#7d2ae7]">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
            <select name="status" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#7d2ae7] focus:border-[#7d2ae7]">
                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.subadmin.index') }}"
               class="border px-6 py-2.5 rounded-lg hover:bg-gray-50 text-sm">
                Batal
            </a>
            <button type="submit"
                    class="flex-1 bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90 transition text-sm font-bold">
                Simpan Subadmin
            </button>
        </div>
    </form>
</div>

@endsection
