@extends('layouts.app')

@section('title', 'Notes')

@section('content')
<div class="p-6">
    @include('layouts.breadcrumbs')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Notes</h1>
        <button @click="openCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i class='bx bx-plus'></i>
            Add Note
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" x-model="search" placeholder="Search notes..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <select x-model="filterVisit" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Visits</option>
                    @foreach($visits as $visit)
                    <option value="{{ $visit->id }}">{{ $visit->client->name }} - {{ $visit->scheduled_at->format('M j, Y g:i A') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Notes Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($notes as $note)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $note->visit->client->name }}</div>
                            <div class="text-sm text-gray-500">{{ $note->visit->scheduled_at->format('M j, Y g:i A') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $note->content }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $note->created_at->format('M j, Y g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button @click="openEditModal({{ $note->id }}, '{{ addslashes($note->content) }}', {{ $note->visit_id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class='bx bx-edit text-lg'></i>
                            </button>
                            <form method="POST" action="{{ route('notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this note?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No notes found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($notes->hasPages())
    <div class="mt-6">
        {{ $notes->links() }}
    </div>
    @endif
</div>

<!-- Create Modal -->
<div x-show="showCreateModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click.self="closeCreateModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Note</h3>
            <form method="POST" action="{{ route('notes.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="create_visit_id" class="block text-sm font-medium text-gray-700 mb-2">Visit</label>
                    <select name="visit_id" id="create_visit_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black">
                        <option value="">Select a visit</option>
                        @foreach($visits as $visit)
                        <option value="{{ $visit->id }}">{{ $visit->client->name }} - {{ $visit->scheduled_at->format('M j, Y g:i A') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="create_content" class="block text-sm font-medium text-gray-700 mb-2">Note Content</label>
                    <textarea name="content" id="create_content" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black" placeholder="Enter your note..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="closeCreateModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Create Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div x-show="showEditModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click.self="closeEditModal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Note</h3>
            <form method="POST" action="" x-ref="editForm">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_visit_id" class="block text-sm font-medium text-gray-700 mb-2">Visit</label>
                    <select name="visit_id" id="edit_visit_id" x-ref="editVisitId" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black">
                        <option value="">Select a visit</option>
                        @foreach($visits as $visit)
                        <option value="{{ $visit->id }}">{{ $visit->client->name }} - {{ $visit->scheduled_at->format('M j, Y g:i A') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="edit_content" class="block text-sm font-medium text-gray-700 mb-2">Note Content</label>
                    <textarea name="content" id="edit_content" x-ref="editContent" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black" placeholder="Enter your note..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="closeEditModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Update Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notesApp', () => ({
            search: '',
            filterVisit: '',
            showCreateModal: false,
            showEditModal: false,
            editingId: null,

            openCreateModal() {
                this.showCreateModal = true;
            },

            closeCreateModal() {
                this.showCreateModal = false;
            },

            openEditModal(id, content, visitId) {
                this.editingId = id;
                this.$refs.editForm.action = `/notes/${id}`;
                this.$refs.editContent.value = content;
                this.$refs.editVisitId.value = visitId;
                this.showEditModal = true;
            },

            closeEditModal() {
                this.showEditModal = false;
                this.editingId = null;
            }
        }));
    });
</script>
@endsection