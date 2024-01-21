@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main class="px-12 mx-auto w-full md:w-5/6 space-y-6">
        <a href="{{ route('parse-news') }}" class="border rounded-md p-4 text-white bg-blue-500 hover:bg-blue-700 transition-colors ease-in-out duration-150 font-semibold w-fit ml-auto inline-flex">Fetch News Update</a>
        <section class="w-full flex flex-col">
        @if(count($news) > 0)
            @foreach($news as $item)
            <div class="border-b w-full flex gap-x-4 justify-start items-stretch py-4">
                <div class="">
                    <img class="size-24 min-w-24 md:size-32 md:min-w-32" src="{{ $item->image }}" alt="{{ $item->title }}">
                </div>
                <div class="grow flex flex-col">
                    <div class="w-full mb-3">
                        <a href="{{ $item->link }}" target="_blank" class="block w-full md:w-5/6 font-medium text-lg md:text-xl m-0 line-clamp-2">{{ $item->title }}</a>
                        <p class="w-full md:w-4/6 text-sm font-light line-clamp-2">{{ $item->description }}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-auto">{{ date("g:i A, F jS, Y", strtotime($item->date_added) ) }}</p>
                </div>
            </div>
            @endforeach
        <div class="w-full my-6">
            {{ $news->links() }}
        </div>
        @else
        <p>No news articles available</p>
        @endif
        </section>
    </main>
@endsection