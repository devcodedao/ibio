@extends('layouts.home')

@section('page-title')
{{ __(config('app.name') . " | Your only one bio link") }}
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
@endpush

@section('content')
<div class="w-full flex flex-col items-center justify-center py-20 px-5">
    <div class="text-center">
        <h1 class="font-bold text-5xl text-transparent bg-clip-text bg-gradient-to-r from-primary-800 to-primary-600">{{ __("Get one link for all of your links!") }}</h1>
        <p class="text-xl mt-5">{{ __("With " . config('app.name') . " you can simply put all of your links into one and share it on your social media") }}</p>
    </div>
    <div class="container flex items-center justify-center mt-10">
        @include('components.ShortUrls.create')
    </div>
    <a href="{{ route('register') }}" class="mt-10 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-primary-600 to-secondary-600 font-semibold font-normal text-white transition hover:from-primary-600 hover:to-primary-600 focus:outline-none disabled:opacity-25 px-4 py-2 text-xl w-max">
        {{ __("Get your FREE account now!") }}
    </a>
    <div class="container mt-10 flex items-center justify-center">
        <div class="flex flex-col items-center justify-center mx-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-primary-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <div class="text-4xl mt-3">{{ \App\Models\User::query()->count() }}</div>
        </div>
        <div class="flex flex-col items-center justify-center mx-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-primary-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
            </svg>
            <div class="text-4xl mt-3">{{ \App\Models\Urls::query()->count() +  \App\Models\Link::query()->count() }}</div>
        </div>
        <div class="flex flex-col items-center justify-center mx-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-primary-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
            </svg>
            <div class="text-4xl mt-3">{{ \App\Models\Theme::query()->whereNull('user_id')->count() }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/carousel.js') }}"></script>
<script>
    var config = {
        app_url: "{{ config('app.url') }}",
        app_name: "{{ config('app.name') }}",
    };

    jQuery(document).ready(function() {
        jQuery("#guest-shorten").submit(function(e) {
            e.preventDefault();
            var formWrap = jQuery(this);
            var formData = jQuery(this).serialize()
            jQuery.ajax({
                type: "POST",
                url: jQuery(this).prop('action'),
                data: formData,
                success: function(data){
                    formWrap.replaceWith(data);
                },
                error: function(data){
                    var errors = data.responseJSON;

                    $.each( errors.errors, function( key, value ) {
                        $('input[name='+key+']').siblings(".error").find('.msg').text(value[0]);
                        $('input[name='+key+']').siblings(".error").show();
                    });
                }
            });
        });

        jQuery(document).on("click", "#shorten-another", function(e){
            location.replace("{{ route('home') }}");
        })
    });
</script>
@endpush