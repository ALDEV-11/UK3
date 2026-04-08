<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold tracking-tight leading-tight" style="color: #2C1810;">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #FFF8F3;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow-lg rounded-2xl border border-[#F5A623]">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-lg rounded-2xl border border-[#F5A623]">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow-lg rounded-2xl border border-[#F5A623]">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
