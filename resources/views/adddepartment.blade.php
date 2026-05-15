<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
</head>
<body>

<h1>Add Department</h1>

<form action="/adddepartment" method="post">

    @csrf

    <input
        type="text"
        name="department_name"
        placeholder="Enter Department Name"
    >

    <button>Add Department</button>

</form>

</body>
</html>