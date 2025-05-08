<?php
$requireAdmin = true;
include 'session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhaka Metro Rail</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kameron:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/body.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/lost&found.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="Js/dashboard.js"></script>
    <script src="Js/index.js"></script>
    <style>
        .btn-publish {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 5px;
        }
        .btn-published {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 5px;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <img src="picture/logo.png" alt="Dhaka Metro Rail" style="max-height: 80px;">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="admindashboard.php">DASHBOARD</a></li>
                    <li><a href="updatenotice.php">UPDATE NOTICE</a></li>
                    <li><a href="lost&found.php">LOST & FOUND</a></li>
                    <li><a href="complain.php">COMPLAIN BOX</a></li>
                    <li><a href="logout.php" id="signout-link">LOGOUT</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div style="padding-top: 130px;padding-bottom: 30px;" class="container">
        <div class="card">
            <h2>Lost & Found Items</h2>
            <div class="filter-tabs">
                <button class="tab-btn active" onclick="filterItems('all')">All Items</button>
                <button class="tab-btn" onclick="filterItems('Lost')">Lost Items</button>
                <button class="tab-btn" onclick="filterItems('Found')">Found Items</button>
            </div>

            <table class="lost-found-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="itemTableBody"></tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Company Information:</h3>
                <p>Dhaka Mass Transit Company Limited (DMTCL)</p>
                <p>Metro Rail Bhaban, Uttara, Dhaka-1230, Bangladesh</p>
                <p>Email: info@dmtcl.gov.bd</p>
                <p>☎ Helpline: +880 1234 567 890</p>
            </div>
            <div style="margin-left: 50px;padding-left: 50px;" class="footer-section">
                <h3>About</h3>
                <p style="line-height: 3ch; text-align: justify;">Dhaka Metro Rail is a modern mass rapid transit system operated by Dhaka Mass Transit Company Limited (DMTCL). It aims to provide a fast, safe, and eco-friendly transportation solution for the people of Dhaka, reducing congestion and improving urban mobility.</p>
            </div>
            <div style="margin-left: 120px;" class="footer-section">
                <h3>Quick Links:</h3>
                <p>Contact Us</p>
                <p>FAQs</p>
                <p>Terms & Conditions</p>
                <p>Privacy Policy</p>
                <h3>Follow Us:</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com" target="_blank" class="text-dark me-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="https://twitter.com" target="_blank" class="text-dark me-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://www.instagram.com" target="_blank" class="text-dark me-3"><i class="fab fa-instagram fa-2x"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">
        <p><strong>Copyright & Disclaimer:</strong></p>
        <p>&copy; 2025 Dhaka Mass Transit Company Limited (DMTCL). All rights reserved.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('get_lost_found.php')
                .then(res => res.json())
                .then(data => {
                    window.lostFoundItems = data;
                    renderItemTable(data);
                });
        });

        function renderItemTable(itemsToShow) {
            const tableBody = document.getElementById('itemTableBody');
            tableBody.innerHTML = '';

            itemsToShow.forEach(item => {
                const row = document.createElement('tr');
                
                // Determine publish button appearance
                let publishButton;
                if (item.isPublished == 1) {
                    publishButton = `<button onclick="togglePublish(${item.id}, 0)" class="btn-published"><i class="fas fa-check-circle"></i> Published</button>`;
                } else {
                    publishButton = `<button onclick="togglePublish(${item.id}, 1)" class="btn-publish"><i class="fas fa-upload"></i> Publish</button>`;
                }
                
                row.innerHTML = `
                    <td>${item.date}</td>
                    <td>${item.name}</td>
                    <td>${item.phone_number}</td>
                    <td>${item.type}</td>
                    <td>${item.description}</td>
                    <td><img src="${item.photo_url}" alt="Item photo" class="item-photo" style="max-width: 80px;"></td>
                    <td>
                        ${publishButton}
                        <button onclick="deleteItem(${item.id})" class="btn-delete"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        function filterItems(type) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            if (type === 'all') {
                renderItemTable(window.lostFoundItems);
            } else {
                const filtered = window.lostFoundItems.filter(item => item.type === type);
                renderItemTable(filtered);
            }
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`delete_lost_found.php?id=${id}`, { method: 'GET' })
                    .then(res => res.text())
                    .then(response => {
                        alert(response);
                        window.lostFoundItems = window.lostFoundItems.filter(i => i.id !== id);
                        renderItemTable(window.lostFoundItems);
                    });
            }
        }

        function togglePublish(id, publishStatus) {
            fetch(`toggle_publish_lost_found.php?id=${id}&publish=${publishStatus}`, { method: 'GET' })
                .then(res => res.text())
                .then(response => {
                    // Update the local data
                    const itemIndex = window.lostFoundItems.findIndex(i => i.id === id);
                    if (itemIndex !== -1) {
                        window.lostFoundItems[itemIndex].isPublished = publishStatus;
                        renderItemTable(window.lostFoundItems);
                    }
                })
                .catch(error => {
                    console.error('Error toggling publish status:', error);
                    alert('Failed to update publish status. Please try again.');
                });
        }
    </script>
</body>
</html>