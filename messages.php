<?php
// Database configuration
$host = "localhost";
$user = "root";        // change if needed
$pass = "";            // change if needed
$dbname = "portfolio";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ DB Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-6xl mx-auto py-10">
        <h1 class="text-4xl font-bold text-center text-blue-700 mb-8">📩 Messages Dashboard</h1>

        <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-blue-600 text-white text-md">
                    <tr>
                        <th class="py-3 px-4 border">ID</th>
                        <th class="py-3 px-4 border">Name</th>
                        <th class="py-3 px-4 border">Email</th>
                        <th class="py-3 px-4 border">Subject</th>
                        <th class="py-3 px-4 border">Message</th>
                        <th class="py-3 px-4 border">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-blue-50 transition">
                                <td class="py-2 px-4 border text-gray-600"><?php echo $row['id']; ?></td>
                                <td class="py-2 px-4 border font-semibold text-gray-800"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="py-2 px-4 border text-blue-600">
                                    <a href="mailto:<?php echo $row['email']; ?>" class="hover:underline">
                                        <?php echo htmlspecialchars($row['email']); ?>
                                    </a>
                                </td>
                                <td class="py-2 px-4 border text-gray-700"><?php echo htmlspecialchars($row['subject']); ?></td>
                                <td class="py-2 px-4 border text-gray-600"><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                                <td class="py-2 px-4 border text-gray-500"><?php echo $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No messages yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
<?php $conn->close(); ?>
