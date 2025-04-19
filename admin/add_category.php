<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 96%;
        }

        textarea {
            resize: none;
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
    <div class="container">
        <h2>Add New Category</h2>
        <form action="add_category_action.php" method="POST">
            <input type="text" name="category_name" placeholder="Category Name" required>
            <button type="submit">Add Category</button>
        </form>
    </div>
</body>
</html>
