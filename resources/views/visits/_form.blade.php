{{-- Shared visit form fields; expects $clients (collection), and optional $visit --}}
<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-gray-700">Client</label>
        <select name="client_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black" required>
            <option value="">Select a client</option>
            @foreach ($clients as $client)
            <option value="{{ $client->id }}" @selected(old('client_id', optional($visit)->client_id) == $client->id)>{{ $client->name }}</option>
            @endforeach
        </select>
        @error('client_id')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-700">Scheduled At</label>
        <input type="text" name="scheduled_at" value="{{ old('scheduled_at', optional(optional($visit)->scheduled_at)->format('Y-m-d H:i')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black js-datetime" required>
        @error('scheduled_at')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    @if($visit)
    <div>
        <label class="block text-gray-700">Completed At</label>
        <input type="text" name="completed_at" value="{{ old('completed_at', optional(optional($visit)->completed_at)->format('Y-m-d H:i')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black js-datetime">
        @error('completed_at')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    @endif
</div>