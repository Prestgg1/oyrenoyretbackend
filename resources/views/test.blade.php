<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="{{ route('login') }}" method="post">
    @csrf
    <input type="text" name="email">
    <input type="text" name="password" id="">
    <button type="submit">Login</button>
  </form>
</body>
</html>
