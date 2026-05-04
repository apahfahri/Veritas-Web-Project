@extends('layouts.admin')
@section('page-title', 'Tambah Admin Cabang')

@section('content')

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.admin-cabang.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
            <input type="text" name="username" value="{{ old('username') }}" required
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#00A8A8] focus:border-[#00A8A8]">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#00A8A8] focus:border-[#00A8A8]">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#00A8A8] focus:border-[#00A8A8]">
            <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter.</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
            <select name="status" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-[#00A8A8] focus:border-[#00A8A8]">
                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.admin-cabang.index') }}"
               class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm cursor-pointer">
                Batal
            </a>
            <button type="submit"
                    class="bg-[#00A8A8] text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm font-medium cursor-pointer">
                Simpan Admin
            </button>
        </div>
    </form>
</div>

@endsection
