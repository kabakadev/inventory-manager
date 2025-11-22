<?php
require 'db_connect.php';

// --- HANDLE FORM SUBMISSION (CREATE) ---
// We check if the server request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Prepared Statements prevent SQL Injection (Security Best Practice)
    $stmt = $conn->prepare("INSERT INTO products (name, quantity, price) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $name, $quantity, $price); // s=string, i=int, d=double

    if ($stmt->execute()) {
        $message = "Product added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// --- HANDLE DELETION (DELETE) ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    // Redirect to clear the URL parameter
    header("Location: index.php");
    exit();
}

// --- FETCH DATA (READ) ---
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Inventory Manager</title>
    <!-- Using Tailwind CSS for UI/UX Awareness (as requested in the Job Ad) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-orange-600 p-6">
            <h1 class="text-white text-2xl font-bold">FastNet Inventory Manager</h1>
            <p class="text-orange-100">PHP & MySQL Demo Application</p>
        </div>

        <div class="p-6">
            <!-- Status Messages -->
            <?php if (isset($message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <!-- Input Form -->
            <form method="POST" class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="name" placeholder="Product Name" required class="border p-2 rounded w-full">
                <input type="number" name="quantity" placeholder="Qty" required class="border p-2 rounded w-full">
                <input type="number" step="0.01" name="price" placeholder="Price" required class="border p-2 rounded w-full">
                <button type="submit" name="add_product" class="bg-gray-800 text-white p-2 rounded hover:bg-gray-700 transition">
                    Add Product
                </button>
            </form>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-2 px-4 border-b text-left">ID</th>
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            <th class="py-2 px-4 border-b text-left">Quantity</th>
                            <th class="py-2 px-4 border-b text-left">Price</th>
                            <th class="py-2 px-4 border-b text-left">Date Added</th>
                            <th class="py-2 px-4 border-b text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b"><?= $row['id'] ?></td>
                                    <td class="py-2 px-4 border-b font-semibold"><?= htmlspecialchars($row['name']) ?></td>
                                    <td class="py-2 px-4 border-b"><?= $row['quantity'] ?></td>
                                    <td class="py-2 px-4 border-b">$<?= number_format($row['price'], 2) ?></td>
                                    <td class="py-2 px-4 border-b text-gray-500 text-sm"><?= $row['created_at'] ?></td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="index.php?delete=<?= $row['id'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>