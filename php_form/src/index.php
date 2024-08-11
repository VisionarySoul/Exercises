<?php
//// DB intialized--Postgresql
// $host = 'localhost';
// $dbname = 'mydb';
// $user = 'myuser';
// $password = 'mypassword';
// $port = '5432';
$dbFile = '/var/www/html/data/database.db';
// Connect to PostgreSQL

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbFile = '/var/www/html/data/database.db';

try {
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create table if it doesn't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS discounts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            product TEXT NOT NULL,
            coupon TEXT NOT NULL,
            city TEXT NOT NULL,
            country TEXT NOT NULL,
            address TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);

    // Prepare and execute SQL statement to insert data
    $stmt = $pdo->prepare("
        INSERT INTO discounts (name, email, product, coupon, city, country, address)
        VALUES (:name, :email, :product, :coupon, :city, :country, :address)
    ");
    $stmt->execute([
        'name' => $input['name'],
        'email' => $input['email'],
        'product' => $input['product'],
        'coupon' => $input['coupon'],
        'city' => $input['city'],
        'country' => $input['country'],
        'address' => $input['address']
    ]);

    $response = [
        'success' => true,
        'message' => 'Discount registration successful for ' . htmlspecialchars($input['name']) . '!'
    ];
    echo json_encode($response);
    exit;
}

// Handle data retrieval
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch'])) {
    header('Content-Type: application/json');

    // Fetch all records from the database
    $stmt = $pdo->query("SELECT * FROM discounts ORDER BY created_at DESC");
    $discounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($discounts);
    exit;
}

// Handle GET request to fetch a random coupon
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_coupon'])) {
    header('Content-Type: application/json');

    // Simulate fetching a random coupon (replace with actual logic)
    $coupons = [
        ['code' => 'COUPON1', 'discount' => '10% off'],
        ['code' => 'COUPON2', 'discount' => '20% off'],
        ['code' => 'COUPON3', 'discount' => '30% off'],
    ];
    $randomCoupon = $coupons[array_rand($coupons)];

    echo json_encode($randomCoupon);
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imaginary Tech Solutions</title>
    <style>
        :root {
            --primary-color: #C0C0C0; /* Silver color */
            --secondary-color: #707070; /* Darker silver for contrast */
            --background-color: #f7f7f7;
            --text-color: #333;
            --glow-color: rgba(255, 255, 255, 0.8);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center; /* Align items on the same line */
        }

        h1 {
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .navbar .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .navbar button {
            background-color: transparent; /* Remove the silver box */
            color: white;
            padding: 0.5rem 1rem;
            border: 2px solid white; /* Optional border */
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar button:hover {
            background-color: white;
            color: var(--secondary-color);
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 0;
        }

        .about, .discount-form {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 0 20px var(--glow-color);
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        form {
            display: grid;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input, select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: var(--secondary-color);
        }

        #response {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 4px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        footer {
            background-color: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .about, .discount-form {
                padding: 1.5rem;
            }

            header {
                flex-direction: column;
            }

            .navbar .nav-buttons {
                flex-direction: column;
                align-items: flex-end;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Imaginary Tech Solutions</h1>
        <nav class="navbar">
            <div class="nav-buttons">
                <button id="randomCouponBtn">Show Random Coupon</button>
                <button id="activateBtn" style="background-color: white;">Not Active</button>
            </div>
        </nav>
    </header>

    <main>
        <section class="about">
            <h2>About Us</h2>
            <p>Imaginary Tech Solutions is at the forefront of imaginary technology. We specialize in creating solutions that don't exist yet, but probably should. Our team of dreamers and innovators works tirelessly to bring the impossible into reality.</p>
        </section>

        <section class="discount-form">
            <h2>Register for a Discount</h2>
            <form id="discountForm">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="product">Product:</label>
                    <select id="product" name="product" required>
                        <option value="">Select a product</option>
                        <option value="imaginary-ai">Imaginary AI</option>
                        <option value="dream-enhancer">Dream Enhancer</option>
                        <option value="thought-translator">Thought Translator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="coupon">Coupon Code:</label>
                    <input type="text" id="coupon" name="coupon">
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <button type="submit">Register for Discount</button>
            </form>
            <div id="response"></div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Imaginary Tech Solutions. All rights imaginarily reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const randomCouponBtn = document.getElementById('randomCouponBtn');
        const couponInput = document.getElementById('coupon');
        const activateBtn = document.getElementById('activateBtn');

        const form = document.getElementById('discountForm');
        const responseDiv = document.getElementById('response');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const data = Object.fromEntries(formData);

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(result => {
                responseDiv.innerHTML = `<p class="success">${result.message}</p>`;
                form.reset();
            })
            .catch(error => {
                responseDiv.innerHTML = `<p class="error">Error: ${error.message}</p>`;
            });
        });
        
        randomCouponBtn.addEventListener('click', function() {
        const couponLength = 8; // Change this to the desired length of the coupon code
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Define the characters to use for the coupon code
        let couponCode = '';

        for (let i = 0; i < couponLength; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            couponCode += characters[randomIndex];
        }

        couponInput.value = couponCode;
        activateBtn.style.backgroundColor = 'green'; // Change background color to green
        activateBtn.textContent = 'Active';
    });
});
    </script>
</body>
</html>
