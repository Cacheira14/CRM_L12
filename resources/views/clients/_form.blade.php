{{-- Shared client form fields; expects $client (nullable) --}}
<div class="grid grid-cols-1 gap-4">
    <div>
        <label class="block text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', optional($client)->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black" required>
        @error('name')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', optional($client)->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black">
        @error('email')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-700">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', optional($client)->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black">
        @error('phone')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-700">Address</label>
        <input type="text" name="address" value="{{ old('address', optional($client)->address) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black">
        @error('address')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700">City</label>
            <input type="text" name="city" value="{{ old('city', optional($client)->city) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black">
            @error('city')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700">Country</label>
            <input type="text" name="country" value="{{ old('country', optional($client)->country) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-black">
            @error('country')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>