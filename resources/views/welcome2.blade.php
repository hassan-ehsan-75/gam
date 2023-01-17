@extends('layouts.app')
@section('content')
<p>
  <h2 class="mt-20 text-blue-500 flex flex-col justify-center items-center">Home Page</h2>

  <a href="{{ route('allArticles')}}" type="submit" class="bg-blue-500 ml-3 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
    Dashboard
  </a>
</p>
@stop