<!DOCTYPE html>
<html>

<head>
    <title>Create User</title>
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
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Add New Admin</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Include database configuration directly here
            $host = 'localhost';
            $db = 'product_site';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                $pdo = new PDO($dsn, $user, $pass, $options);

                // Get username and password from POST request
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                if ($stmt->execute([$username, $hashedPassword])) {
                    echo "<p style='color: green;'>✅ '$username' added successfully!</p>";
                } else {
                    echo "<p style='color: red;'>❌ Failed to add user.</p>";
                }
            } catch (PDOException $e) {
                echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
            }
        }
        ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Enter Username" required />
            <input type="password" name="password" placeholder="Enter Password" required />
            <button type="submit">Create User</button>
        </form>
    </div>
</body>

</html>
