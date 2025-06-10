@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')
    <div class="bg-white shadow rounded-lg p-6 mb-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Kelola Data Pengguna</h1>
        </div>

        @if ($data_user->isEmpty())
            <div class="text-[#92400e] bg-[#ffedd5] p-4 rounded">
                Belum ada pengguna terdaftar.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Terakhir Login</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-700">
                        @foreach ($data_user as $user)
                            <tr>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d M Y H:i') : 'Belum pernah login' }}
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prediksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
    dusk="hapus-user"
    class="inline-flex items-center px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
    <i class="fas fa-trash mr-1"></i> Hapus
</button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $data_user->links() }}
            </div>
        @endif
    </div>
@endsection
