@include('common.header')

<h1>This is home Page</h1>
<x-message-banner msg="user login succesfuly"
pre="Mr."/>
<x-message-banner msg="user sign in succesfuly"
 pre="Mr."/>




@include('common.inner',['page'=>"this is home page"])
<a href="/">welcome page</a>
<a href="/about/rahul dangi"> About page</a>  
<a href="/logout">Logout</a>