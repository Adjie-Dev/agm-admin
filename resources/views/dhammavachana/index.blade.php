@extends('layouts.app')

@section('title', 'dhammavācanā')
@section('header', 'DHAMMA VĀCANĀ')

@section('content')
<div class="mb-4">
    <a href="{{ route('dhammavachana.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Tambah Dhamma vācanā
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cover</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Halaman</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diupload</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($dhammavachanas as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($item->cover_image)
                            <img src="{{ asset('storage/' . $item->cover_image) }}" alt="{{ $item->title }}" class="h-16 w-12 object-cover">
                        @else
                            <div class="h-16 w-12 bg-gray-200 flex items-center justify-center text-gray-400">
                                📄
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $item->title }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($item->description ?? '', 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->page_count }} hal</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->uploader->name ?? 'Unknown' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('dhammavachana.show', $item) }}" class="text-green-600 hover:text-green-900 mr-3">Lihat</a>
                        <a href="{{ route('dhammavachana.edit', $item) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                        <form action="{{ route('dhammavachana.destroy', $item) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data dhammavācanā</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $dhammavachanas->links() }}
</div>
@endsection
