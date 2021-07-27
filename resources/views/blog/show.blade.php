@extends('layouts.app')

@section('content')
<div class="w-4/5 m-auto text-left">
    <div class="py-15">
        <h1 class="text-6xl">
            {{ $post->title }}
        </h1>
    </div>
</div>

<!-- <div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-15 border-b border-gray-200">
    <span class="tex-gray-500">
        By 
        <span class="font-bold italic text-gray-800"> {{ $post->user->name }} </span>
        , Created on {{ date('jS M Y',strtotime($post->updated_at)) }}
    </span>    
    <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
        {{ $post->description }}
    </p>    
</div> -->

<div>
    <span class="text-gray-500 ml-32">
        By 
        <span class="font-bold italic text-gray-800"> {{ $post->user->name }} </span>, 
        Created on {{ date('jS M Y',strtotime($post->updated_at)) }}
    </span>
    <div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-15 border-b border-gray-200">
        <div>
            <img src="{{ asset('images/'. $post->image_path) }}" width="700" alt="post image">
        </div>
        <div>
            <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
                {{ $post->description }}
            </p>
        </div>
    </div>
</div>
    

@endsection