@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Visit</h1>
    <form action="{{ route('visits.update', $visit) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label class="block text-gray-700">Client</label>
            <select name="client_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @foreach ($clients as $client)
                <option value="{{ $client->id }}" @if($visit->client_id == $client->id) selected @endif>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Scheduled At</label>
            <input type="datetime-local" name="scheduled_at" value="{{ $visit->scheduled_at->format('Y-m-d\TH:i') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Completed At</label>
            <input type="datetime-local" name="completed_at" value="{{ $visit->completed_at ? $visit->completed_at->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('visits.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection