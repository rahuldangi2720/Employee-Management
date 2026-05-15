@include('common.header')

<h1> About page</h1>

@includeif('common.inner' , ['page'=> "this is about page"])

<h1>{{$name}}</h1>