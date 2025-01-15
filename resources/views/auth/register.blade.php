<x-layout title="Register">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
            class="form-container grid grid-cols-1 md:grid-cols-2 gap-2">
            @csrf
            <h2 class="form-title col-span-1 md:col-span-2">Create Your Account</h2>

            <!-- Name Input Field -->
            <div class="form-group">
                <label for="name" class="form-label">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" placeholder="John Doe" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Input Field -->
            <div class="form-group">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="name@example.com" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input Field -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Input Field -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                @error('password_confirmation')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number Input Field -->
            <div class="form-group">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" id="phone_number" value="{{ old('phone_number') }}" name="phone_number" class="form-input" placeholder="+1234567890"
                    required>
                @error('phone_number')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- City Input Field -->
            <div class="form-group">
                <label for="city" class="form-label">City</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-input" placeholder="City Name" required>
                @error('city')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address Input Field -->
            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <input id="address" name="address" value="{{ old('address') }}" class="form-input" placeholder="Your Address" required>
                @error('address')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- User Type Select Field -->
            <div class="form-group">
                <label for="user_type" class="form-label">Register As</label>
                <select id="user_type" name="user_type" class="form-input" required>
                <option value="2" {{ old('user_type') == '2' ? 'selected' : '' }}>Investor</option>
                <option value="3" {{ old('user_type') == '3' ? 'selected' : '' }}>Entrepreneur</option>
                </select>
                @error('user_type')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profile Image Upload Field -->
            <div class="form-group col-span-1 md:col-span-2"">
                <label for="profile_image" class="form-label">Profile Image (Optional)</label>
                <input type="file" id="profile_image" name="profile_image" class="form-input-file">
                @error('profile_image')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="col-span-1 md:col-span-2">
                <button type="submit" class="btn-primary w-full">Register</button>
            </div>

            <div class="mt-4 text-center col-span-1 md:col-span-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Already have an account?
                    <a href="/login" class="text-blue-600 hover:underline dark:text-blue-500">Login</a>
                </p>
            </div>
        </form>

    </div>
</x-layout>
