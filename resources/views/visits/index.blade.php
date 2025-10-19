@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-2 sm:px-4" x-data="{ q: '' }">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                <i class='bx bxs-calendar-event text-blue-600'></i>
                Visits
                <span class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-700">{{ $visits->count() }}</span>
            </h1>
            <p class="text-gray-500 mt-1">Schedule and track client visits.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto mt-4 sm:mt-0">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                <input type="text" x-model="q" placeholder="Search by client or date..." class="pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <button type="button" @click="$dispatch('open-modal', 'create-visit')" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                <i class='bx bx-plus'></i>
                Add Visit
            </button>
        </div>
    </div>
    <div class="bg-white shadow ring-1 ring-black/5 rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Scheduled At</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Completed At</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($visits as $visit)
                <tr class="hover:bg-gray-50 transition" x-show="([
                        @js($visit->client->name),
                        @js(optional($visit->scheduled_at)->format('Y-m-d H:i')),
                        @js(optional($visit->completed_at)->format('Y-m-d H:i'))
                    ].join(' ').toLowerCase().includes(q.toLowerCase()))">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $visit->client->name }}</div>
                        <div class="text-gray-500">Visit #{{ $visit->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2">
                            <i class='bx bx-time-five text-gray-500'></i>
                            {{ optional($visit->scheduled_at)->format('Y-m-d H:i') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($visit->completed_at)
                        <span class="inline-flex items-center gap-2 text-green-700">
                            <i class='bx bx-check-circle'></i>
                            {{ optional($visit->completed_at)->format('Y-m-d H:i') }}
                        </span>
                        @else
                        <span class="inline-flex items-center gap-2 text-gray-400">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                            Pending
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="inline-flex items-center gap-2">
                            <button type="button" @click="$dispatch('open-modal', 'edit-visit-{{ $visit->id }}')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                <i class='bx bx-edit-alt'></i>
                                Edit
                            </button>
                            <form action="{{ route('visits.destroy', $visit) }}" method="POST" class="inline" onsubmit="return confirm('Delete this visit?')">
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
                <!-- Edit Visit Modal {{ $visit->id }} -->
                <x-modal name="edit-visit-{{ $visit->id }}" :show="false" maxWidth="2xl">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Edit Visit</h2>
                        <form action="{{ route('visits.update', $visit) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="form_context" value="edit-{{ $visit->id }}">
                            @include('visits._form', ['visit' => $visit, 'clients' => $clients])
                            <div class="mt-6 flex justify-end gap-2">
                                <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data @click="$dispatch('close-modal', 'edit-visit-{{ $visit->id }}')">Cancel</button>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                            </div>
                        </form>
                    </div>
                </x-modal>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16">
                        <div class="text-center">
                            <i class='bx bxs-calendar-x text-4xl text-gray-300'></i>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900">No visits</h3>
                            <p class="mt-1 text-sm text-gray-500">Start by adding a new visit.</p>
                            <div class="mt-6">
                                <button type="button" @click="$dispatch('open-modal', 'create-visit')" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                                    <i class='bx bx-plus'></i>
                                    Add Visit
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Create Visit Modal -->
    <x-modal name="create-visit" :show="false" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Add Visit</h2>
            <form action="{{ route('visits.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="form_context" value="create">
                @include('visits._form', ['visit' => null, 'clients' => $clients])
                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data @click="$dispatch('close-modal', 'create-visit')">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </x-modal>

    @php $ctx = old('form_context'); @endphp
    @if ($ctx)
    @php $modalName = $ctx === 'create' ? 'create-visit' : ('edit-visit-' . \Illuminate\Support\Str::after($ctx, 'edit-')); @endphp
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