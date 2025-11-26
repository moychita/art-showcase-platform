@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Pengguna</h1>
            <p class="text-gray-500 mt-1">Kelola role dan status Member, Curator, maupun Admin lain.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengguna</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-4 py-4 capitalize text-sm text-gray-700">{{ $user->role }}</td>
                        <td class="px-4 py-4 capitalize text-sm text-gray-700">{{ $user->status }}</td>
                        <td class="px-4 py-4 space-y-3">
                            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-2">
                                @csrf
                                @method('PUT')
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <select name="role" class="border rounded px-3 py-2 text-sm">
                                        <option value="member" @selected($user->role === 'member')>Member</option>
                                        <option value="curator" @selected($user->role === 'curator')>Curator</option>
                                        <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    </select>
                                    <select name="status" class="border rounded px-3 py-2 text-sm">
                                        <option value="active" @selected($user->status === 'active')>Aktif</option>
                                        <option value="pending" @selected($user->status === 'pending')>Pending</option>
                                        <option value="suspended" @selected($user->status === 'suspended')>Suspended</option>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">
                                        Simpan
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                    Hapus Pengguna
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                            Belum ada data pengguna lain.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection

