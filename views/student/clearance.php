<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Clearance Requests</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">Clearance Requests</h2>

        <?php if (isset($msg)): ?>
            <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <?php if (isset($eligible) && $eligible): ?>
            <form method="POST" action="index.php?url=student/submit-clearance">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Request Clearance
                </button>
            </form>
        <?php else: ?>
            <div class="mb-4 text-gray-600">
                You are not eligible to request clearance. Please ensure all payments are settled and your booking is active.
            </div>
        <?php endif; ?>

        <table class="table-auto w-full mt-6 bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Requested On</th>
                    <th class="px-4 py-2">Room</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($requests)): ?>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= htmlspecialchars($request['status']) ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($request['request_date']) ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($request['room_number']) ?> (<?= htmlspecialchars($request['room_type']) ?>)</td>
                            <td class="border px-4 py-2">
                                <?php if ($request['status'] === 'approved'): ?>
                                    <a href="index.php?url=student/clearance-certificate&id=<?= $request['id'] ?>" class="text-green-600 hover:underline">Download Certificate</a>
                                <?php elseif ($request['status'] === 'pending'): ?>
                                    <span class="text-yellow-600">Pending Approval</span>
                                <?php elseif ($request['status'] === 'rejected'): ?>
                                    <span class="text-red-600">Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No clearance requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>