@extends('layouts.app')

@section('content')
    <div class="background-image grid grid-cols-1 m-auto">
        <div class="flex text-gray100 pt-10">
            <div class="m-auto pt-4 pb-16 sm:m-auto w-4/5 block text-center">
                <h1 class="sm:text-white text-5xl uppercase font-bold text-shadow-md pb-4">
                    Do you want to be a developer?
                </h1>
                <a href="/blog" class="tex-center bg-gray-50 text-gray-700 py-2 px-4 font-bold text-xl uppercase">
                    Read More
                </a>
            </div>
        </div>
    </div>
    
    <div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-15 borderb border-gray-200">
        <div>
            <img src="https://cdn.pixabay.com/photo/2014/05/03/01/03/laptop-336704_1280.jpg" width="700" alt="">
        </div>
        
        <div class="m-auto sm:m-auto text-left w-4/5 block">
            <h2 class="text-3xl font-extrabold text-gray-600">
                Struggling to be a web developer?
            </h2>
            <p class="py-8 text-gray-500 text-sm">
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Voluptatibus.
            </p>
            <p class="font-extrabold text-gray-600 text-sm pb-9">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                Temporibus laudantium atque at adipisci doloribus ducimus quos, 
                dolorem dignissimos incidunt, nam praesentium sint debitis 
                aspernatur beatae numquam vero! Iure, suscipit fuga?
            </p>
            <a href="/blog" class="uppercase bg-blue-500 text-gray-100 text-sm font-extrabold py-3 px-8 rounded-3xl">
                Find Out More
            </a>
        </div>
    </div>
    

    <div class="text-center p-15 bg-black text-white">
        <h2 class="text-2xl pb-5 text-l">
            Technologies I know:
        </h2>
        <span class="font-extrabold block text-4xl py-1">
            Java
        </span>
        <span class="font-extrabold block text-4xl py-1">
            JavaScript
        </span>
        <span class="font-extrabold block text-4xl py-1">
            Google App Script
        </span>
        <span class="font-extrabold block text-4xl py-1">
            Postman Api
        </span>
    </div>

    <div class="text-center py-15">
        <span class="uppercase text-s text-gray-400">
            Blog
        </span>

        <h2 class="text-4xl font-bold py-10">
            Recent Posts
        </h2>

        <p class="m-auto w-4/5 text-gray-500">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
            Cumque exercitationem saepe enim veritatis, eos temporibus 
            quaerat facere consectetur qui.
        </p>
    </div>

    <div class="sm:grid grid-cols-2 w-4/5 m-auto">
        <div class="flex bg-yellow-700 text-gray-100 pt-2">
            <div class="m-auto pt-4 pb-6 sm:m-auto w-4/5 block">
                <span class="uppercase text-xs">
                    PHP
                </span>
                <h3 class="text-m font-bold pt-6 pb-10">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
                    Voluptas necessitatibus dolorum error culpa laboriosam. 
                    Enim voluptas earum repudiandae consequuntur ad? 
                    Expedita labore aspernatur facilis quasi ex? 
                    Nemo hic placeat et?
                </h3>

                <a href="" class="uppercase bg-transparent border-2 border-gray-100 text-gray-100 text-xs font-extrabold py-3 px-5 rounded-xl">
                    Find Out More
                </a>
            </div>
        </div>
        <div>
            <img src="https://cdn.pixabay.com/photo/2014/05/03/01/03/laptop-336704_960_720.jpg" alt="">
        </div>
    </div>

@endsection