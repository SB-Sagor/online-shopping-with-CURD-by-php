<!-- login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            height: 400px;
        }

        input {
            width: 80%;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 30px;
            background: linear-gradient(135deg, #00c853, #2e7d32);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #2e7d32, #00c853);
            transform: scale(1.01);
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form action="login_action.php" method="POST">
            <input type="text" name="username" placeholder="Enter Username" required />
            <input type="password" name="password" placeholder="Enter Password" required />
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
