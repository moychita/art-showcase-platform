@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-dark">Manajemen Pengguna</h1>
                <p class="mt-1 text-gray-500">Kelola role, status, dan akses pengguna aplikasi.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-dark flex items-center transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <!-- Tabel Users -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <!-- Info User -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                @if($user->avatar)
                                                    <img class="h-10 w-10 rounded-full object-cover ring-2 ring-gray-100" src="{{ Storage::url($user->avatar) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm ring-2 ring-blue-100">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Form Update Role & Status -->
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select name="role" onchange="this.form.submit()" class="block w-full pl-3 pr-8 py-1 text-xs font-medium border-gray-300 focus:outline-none focus:ring-primary focus:border-primary rounded-full bg-gray-50 text-gray-700 cursor-pointer hover:bg-gray-100 transition">
                                                <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                                <option value="curator" {{ $user->role === 'curator' ? 'selected' : '' }}>Curator</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <select name="status" onchange="this.form.submit()" class="block w-full pl-3 pr-8 py-1 text-xs font-bold border-none rounded-full cursor-pointer transition focus:ring-2 focus:ring-offset-1 focus:ring-primary
                                                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : ($user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="pending" {{ $user->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                        </td>
                                    </form>

                                    <!-- Tombol Hapus -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini secara permanen?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-full transition" title="Hapus Pengguna">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="mx-auto h-16 w-16 text-gray-300 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-dark">Belum ada pengguna lain</h3>
                    <p class="mt-1 text-gray-500">Saat ini hanya ada akun Anda di sistem.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection