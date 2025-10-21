@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-2 sm:px-4" x-data="{ q: '' }">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                    <i class='bx bxs-calendar-event text-blue-600'></i>
                    Visits
                    <span
                        class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-700">{{ $visits->count() }}</span>
                </h1>
                <p class="text-gray-500 mt-1">Schedule and track client visits.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto mt-4 sm:mt-0">
                <div class="relative">
                    <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                    <input type="text" x-model="q" placeholder="Search by client or date..."
                        class="pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <button type="button" @click="$dispatch('open-modal', 'create-visit')"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
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
                        <tr class="hover:bg-gray-50 transition"
                            x-show="([
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
                                @if ($visit->completed_at)
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
                                    <button type="button" @click="$dispatch('open-modal', 'add-note-{{ $visit->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-blue-300 text-blue-700 hover:bg-blue-50">
                                        <i class='bx bx-plus'></i>
                                        Add Note
                                    </button>
                                    <button type="button"
                                        @click="$dispatch('open-modal', 'view-notes-{{ $visit->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-green-300 text-green-700 hover:bg-green-50">
                                        <i class='bx bx-show'></i>
                                        View Notes
                                    </button>
                                    <button type="button"
                                        @click="$dispatch('open-modal', 'edit-visit-{{ $visit->id }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                        <i class='bx bx-edit-alt'></i>
                                        Edit
                                    </button>
                                    <form action="{{ route('visits.destroy', $visit) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete this visit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700">
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
                                        <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data
                                            @click="$dispatch('close-modal', 'edit-visit-{{ $visit->id }}')">Cancel</button>
                                        <button type="submit"
                                            class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>
                        <!-- Add Note Modal {{ $visit->id }} -->
                        <x-modal name="add-note-{{ $visit->id }}" :show="false" maxWidth="2xl">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Add Note for {{ $visit->client->name }}
                                </h2>
                                <form action="{{ route('notes.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="visit_id" value="{{ $visit->id }}">
                                    <input type="hidden" name="form_context" value="add-note-{{ $visit->id }}">
                                    <div>
                                        <label for="content-{{ $visit->id }}"
                                            class="block text-sm font-medium text-gray-700 mb-2">Note Content</label>
                                        <textarea id="content-{{ $visit->id }}" name="content" rows="4"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-black"
                                            placeholder="Enter your note..." required></textarea>
                                    </div>
                                    <div class="mt-6 flex justify-end gap-2">
                                        <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data
                                            @click="$dispatch('close-modal', 'add-note-{{ $visit->id }}')">Cancel</button>
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add
                                            Note</button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>
                        <!-- View Notes Modal {{ $visit->id }} -->
                        <x-modal name="view-notes-{{ $visit->id }}" :show="false" maxWidth="3xl">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Notes for {{ $visit->client->name }}
                                </h2>
                                <div class="space-y-4">
                                    @forelse($visit->notes as $note)
                                        <div class="border border-gray-200 rounded-lg p-4" x-data="{ editing: false }"
                                            x-cloak>
                                            <div class="flex justify-between items-start mb-2">
                                                <span
                                                    class="text-sm text-gray-500">{{ $note->created_at->format('M j, Y g:i A') }}</span>
                                                <div class="flex gap-2">
                                                    <button @click="editing = !editing"
                                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                                        <i class='bx bx-edit'></i> Edit
                                                    </button>
                                                    <form action="{{ route('notes.destroy', $note) }}" method="POST"
                                                        class="inline" onsubmit="return confirm('Delete this note?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-800 text-sm">
                                                            <i class='bx bx-trash'></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div x-show="!editing" class="text-gray-900">
                                                {{ $note->content }}
                                            </div>
                                            <div x-show="editing" class="space-y-2">
                                                <form
                                                    @submit.prevent="
                                                    $el.submit();
                                                    editing = false;
                                                "
                                                    action="{{ route('notes.update', $note) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="visit_id" value="{{ $visit->id }}">
                                                    <input type="hidden" name="form_context"
                                                        value="view-notes-{{ $visit->id }}">
                                                    <textarea name="content" rows="3"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-black"
                                                        required>{{ $note->content }}</textarea>
                                                    <div class="flex gap-2">
                                                        <button type="submit"
                                                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Save</button>
                                                        <button type="button" @click="editing = false"
                                                            class="bg-gray-500 text-white px-3 py-1 rounded text-sm">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-gray-500">
                                            <i class='bx bx-note text-4xl text-gray-300'></i>
                                            <p class="mt-2">No notes for this visit yet.</p>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data
                                        @click="$dispatch('close-modal', 'view-notes-{{ $visit->id }}')">Close</button>
                                </div>
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
                                        <button type="button" @click="$dispatch('open-modal', 'create-visit')"
                                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
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
                        <button type="button" class="px-4 py-2 border rounded text-gray-700" x-data
                            @click="$dispatch('close-modal', 'create-visit')">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </x-modal>

        @php $ctx = old('form_context'); @endphp
        @if ($ctx)
            @php
                if ($ctx === 'create') {
                    $modalName = 'create-visit';
                } elseif (str_starts_with($ctx, 'edit-')) {
                    $modalName = 'edit-visit-' . \Illuminate\Support\Str::after($ctx, 'edit-');
                } elseif (str_starts_with($ctx, 'add-note-')) {
                    $modalName = 'add-note-' . \Illuminate\Support\Str::after($ctx, 'add-note-');
                } elseif (str_starts_with($ctx, 'view-notes-')) {
                    $modalName = 'view-notes-' . \Illuminate\Support\Str::after($ctx, 'view-notes-');
                } else {
                    $modalName = null;
                }
            @endphp
            @if ($modalName)
                <script>
                    (function() {
                        var modalName = "{{ $modalName }}";
                        window.dispatchEvent(new CustomEvent('open-modal', {
                            detail: modalName
                        }));
                    })();
                </script>
            @endif
        @endif
    </div>
@endsection
