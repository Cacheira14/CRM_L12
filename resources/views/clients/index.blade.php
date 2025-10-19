@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-2 sm:px-4" x-data="{ q: '' }">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                <i class='bx bxs-user-detail text-blue-600'></i>
                Clients
                <span class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-700">{{ $clients->count() }}</span>
            </h1>
            <p class="text-gray-500 mt-1">Manage your customers and their contact details.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto mt-4 sm:mt-0">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                <input type="text" x-model="q" placeholder="Search clients..." class="pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <button type="button" @click="$dispatch('open-modal', 'create-client')" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                <i class='bx bx-plus'></i>
                Add Client
            </button>
        </div>
    </div>

    <div class="bg-white shadow ring-1 ring-black/5 rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Phone</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($clients as $client)
                <tr class="hover:bg-gray-50 transition" x-show="([@js($client->name), @js($client->email), @js($client->phone)].join(' ').toLowerCase().includes(q.toLowerCase()))">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $client->name }}</div>
                        <div class="text-gray-500">Client #{{ $client->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($client->email)
                        <a href="mailto:{{ $client->email }}" class="text-blue-600 hover:underline">{{ $client->email }}</a>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($client->phone)
                        <a href="tel:{{ $client->phone }}" class="text-gray-700 hover:text-gray-900">{{ $client->phone }}</a>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex items-center gap-2">
                            <button type="button" @click="$dispatch('open-modal', 'edit-client-{{ $client->id }}')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                <i class='bx bx-edit-alt'></i>
                                Edit
                            </button>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Delete this client?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700">
                                    <i class='bx bx-trash'></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <!-- Edit Modal for Client {{ $client->id }} -->
                <x-modal name="edit-client-{{ $client->id }}" :show="false" maxWidth="2xl">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Client</h2>
                        <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="form_context" value="edit-{{ $client->id }}">
                            @include('clients._form', ['client' => $client])
                            <div class="mt-6 flex justify-end gap-2">
                                <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data @click="$dispatch('close-modal', 'edit-client-{{ $client->id }}')">Cancel</button>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                            </div>
                        </form>
                    </div>
                </x-modal>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16">
                        <div class="text-center">
                            <i class='bx bxs-user-x text-4xl text-gray-300'></i>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">No clients</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first client.</p>
                            <div class="mt-6">
                                <button type="button" @click="$dispatch('open-modal', 'create-client')" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                                    <i class='bx bx-plus'></i>
                                    Add Client
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <x-modal name="create-client" :show="false" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Add Client</h2>
            <form action="{{ route('clients.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="form_context" value="create">
                @include('clients._form', ['client' => null])
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data @click="$dispatch('close-modal', 'create-client')">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </x-modal>

    @php $ctx = old('form_context'); @endphp
    @if ($ctx)
    @php $modalName = $ctx === 'create' ? 'create-client' : ('edit-client-' . \Illuminate\Support\Str::after($ctx, 'edit-')); @endphp
    <script>
        (function() {
            var modalName = "{{ $modalName }}";
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: modalName
            }));
        })();
    </script>
    @endif
</div>
@endsection