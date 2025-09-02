<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
<<<<<<< HEAD
            background: #b9d3c9;
=======
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
<<<<<<< HEAD
            background: #052719;
=======
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            color: white;
            padding: 30px;
            text-align: center;
        }

        .login-header h2 {
            margin: 0;
            font-weight: 600;
        }

        .login-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .login-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
<<<<<<< HEAD
            border-color: #052719;
            box-shadow: 0 0 0 0.2rem rgba(5, 39, 25, 0.25);
=======
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .btn-login {
<<<<<<< HEAD
            background: #052719;
=======
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
<<<<<<< HEAD
            box-shadow: 0 10px 20px rgba(5, 39, 25, 0.3);
            background: #0a3d26;
=======
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
<<<<<<< HEAD
            color: #052719;
=======
            color: #667eea;
>>>>>>> a353678cfce4d1f15b5eab45fa396d20e69e8d39
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .hospital-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .text-muted {
            color: #6c757d;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                max-width: none;
            }
            
            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="hospital-icon">
                <i class="fas fa-hospital"></i>
            </div>
            <h2>HMS Login</h2>
            <p>Hospital Management System</p>
        </div>
        
        <div class="login-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="post">
                <div class="form-group">
                    <label for="username" class="form-label">
                        <i class="fas fa-user"></i> Username
                    </label>
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Username" value="<?= old('username') ?>" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Password" required>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>

            <div class="forgot-password">
                <a href="<?= base_url('forgot-password') ?>">
                    <i class="fas fa-question-circle"></i> Forgot Password?
                </a>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i> Secure Hospital Management System
                </small>
            </div>
        </div>
    </div>
</body>
</html>
