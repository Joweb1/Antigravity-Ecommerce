<x-app-layout>
    <div class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <h1 class="text-3xl font-bold text-theme-text">Account Settings</h1>

            {{-- Update Profile Information --}}
            <div class="profile-forms p-4 sm:p-8 bg-theme-bg/50 border border-theme-border rounded-lg shadow-md backdrop-blur-sm">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-theme-text mb-4">Profile Information</h2>
                    <p class="text-sm text-theme-text/70 mb-6">
                        Update your account's profile information and email address.
                    </p>
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Update Password --}}
            <div class="profile-forms p-4 sm:p-8 bg-theme-bg/50 border border-theme-border rounded-lg shadow-md backdrop-blur-sm">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-theme-text mb-4">Update Password</h2>
                    <p class="text-sm text-theme-text/70 mb-6">
                        Ensure your account is using a long, random password to stay secure.
                    </p>
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="profile-forms p-4 sm:p-8 bg-theme-bg/50 border border-theme-border rounded-lg shadow-md backdrop-blur-sm">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-red-500 mb-4">Delete Account</h2>
                    <p class="text-sm text-theme-text/70 mb-6">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                    </p>
                    <livewire:profile.delete-user-form />
                </div>
            </div>

        </div>
    </div>
</x-app-layout>