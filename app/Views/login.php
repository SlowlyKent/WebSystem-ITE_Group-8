<!DOCTYPE html>
<html>
<head>
    <title>Hospital Management - Login</title>
<<<<<<< HEAD
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
=======
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .login-box { width: 300px; margin: 100px auto; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 3px; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Hospital Login</h2>
        <?php if (session()->get('error')): ?>
            <div class="error"><?= session()->get('error') ?></div>
        <?php endif; ?>
        <form method="post" action="/login">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
