@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 font-poppins text-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-lg shadow-md">
                    @include('profile.partials.update-profile-information-form')x
                </div>
                <div class="p-6 rounded-lg shadow-md">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 rounded-lg shadow-md">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection