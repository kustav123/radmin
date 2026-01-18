<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <label class="block text-sm font-semibold text-fg-brand-strong dark:text-fg-brand-softer mb-4">
                    {{ __('Profile Photo') }}
                </label>

                <!-- Current Profile Photo -->
                <div class="mt-3 flex items-center gap-4" x-show="! photoPreview">
                    <div class="relative">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-brand-subtle dark:border-brand-softer shadow-sm">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-brand rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4.5-8 3 4 2.5-4 4 6z"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-fg-neutral-strong dark:text-fg-neutral-softer uppercase tracking-wide">Current photo</p>
                        <p class="text-sm text-fg-neutral-medium dark:text-fg-neutral-medium mt-1">{{ $this->user->name }}</p>
                    </div>
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-3 flex items-center gap-4" x-show="photoPreview" style="display: none;">
                    <div class="relative">
                        <span class="block w-20 h-20 rounded-full bg-cover bg-center border-2 border-brand shadow-sm"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-success rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-fg-success-strong dark:text-fg-success-softer uppercase tracking-wide">New preview</p>
                        <p class="text-sm text-fg-neutral-medium dark:text-fg-neutral-medium mt-1" x-text="photoName"></p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 mt-5">
                    <button type="button" x-on:click.prevent="$refs.photo.click()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand hover:bg-brand-strong text-white text-sm font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand dark:focus:ring-offset-gray-800 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Select A New Photo') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button type="button" wire:click="deleteProfilePhoto" class="inline-flex items-center gap-2 px-5 py-2.5 bg-danger-soft hover:bg-danger-softer text-danger-strong hover:text-danger-medium dark:bg-danger-softer dark:hover:bg-danger-soft dark:text-danger-medium dark:hover:text-danger-strong text-sm font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-danger dark:focus:ring-offset-gray-800 shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            {{ __('Remove Photo') }}
                        </button>
                    @endif
                </div>

                @error('photo')
                    <div class="mt-3 p-3 bg-danger-soft dark:bg-danger-softer border border-danger-subtle dark:border-danger-medium rounded-lg flex gap-2">
                        <svg class="w-5 h-5 text-danger-strong dark:text-danger-medium flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <p class="text-sm font-medium text-danger-strong dark:text-danger-medium">{{ $message }}</p>
                    </div>
                @enderror
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-3 pt-6">
            <label for="name" class="block text-sm font-semibold text-fg-brand-strong dark:text-fg-brand-softer mb-2">
                {{ __('Name') }}
            </label>
            <input id="name" type="text" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-colors duration-200" 
                   wire:model="state.name" required autocomplete="name" />
            @error('state.name')
                <p class="text-sm font-medium text-danger-strong dark:text-danger-softer mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-3 pt-6">
            <label for="email" class="block text-sm font-semibold text-fg-brand-strong dark:text-fg-brand-softer mb-2">
                {{ __('Email') }}
            </label>
            <input id="email" type="email" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent transition-colors duration-200" 
                   wire:model="state.email" required autocomplete="username" />
            @error('state.email')
                <p class="text-sm font-medium text-danger-strong dark:text-danger-softer mt-2">{{ $message }}</p>
            @enderror

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-warning-soft dark:bg-warning-softer border border-warning-subtle dark:border-warning-medium rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-warning-strong dark:text-warning-medium flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-warning-strong dark:text-warning-medium">
                                {{ __('Email Not Verified') }}
                            </p>
                            <p class="text-sm text-warning-strong/75 dark:text-warning-medium/75 mt-1">
                                {{ __('Your email address is unverified. Please verify to continue.') }}
                            </p>
                            <button type="button" class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-brand hover:text-brand-strong transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand rounded dark:focus:ring-offset-gray-800" 
                                    wire:click.prevent="sendEmailVerification">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ __('Resend Verification Email') }}
                            </button>

                            @if ($this->verificationLinkSent)
                                <div class="mt-3 p-2 bg-success-soft dark:bg-success-softer rounded flex gap-2 items-start">
                                    <svg class="w-4 h-4 text-success-strong dark:text-success-medium flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <p class="text-xs font-medium text-success-strong dark:text-success-medium">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="flex items-center gap-4">
            @if (session('status') === 'profile-information-updated')
                <div class="flex items-center gap-2 px-4 py-2.5 bg-success-soft dark:bg-success-softer rounded-lg">
                    <svg class="w-5 h-5 text-success-strong dark:text-success-medium" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <p class="text-sm font-semibold text-success-strong dark:text-success-medium">
                        {{ __('Profile information saved successfully.') }}
                    </p>
                </div>
            @endif
            <button type="submit" wire:loading.attr="disabled" wire:target="photo" class="inline-flex items-center gap-2 px-6 py-2.5 ml-auto bg-brand hover:bg-brand-strong text-white text-sm font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand disabled:opacity-50 disabled:cursor-not-allowed dark:focus:ring-offset-gray-800 shadow-sm hover:shadow-md">
                <svg wire:loading.class="animate-spin" wire:target="photo" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                {{ __('Save Changes') }}
            </button>
        </div>
    </x-slot>
</x-form-section>
