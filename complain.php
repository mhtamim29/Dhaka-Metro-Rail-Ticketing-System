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
    <link rel="stylesheet" href="css/complain.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="Js/dashboard.js"></script>
    <script src="Js/index.js"></script>
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

  <div style="padding-top: 90px;padding-bottom: 30px;" class="container">
    <div class="card">
      <h2>COMPLAIN BOX</h2>
      <table class="complaint-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Station</th>
            <th>Type of Complaint</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="complaintTableBody"></tbody>
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
        <p style="line-height: 3ch;text-align: justify;">Dhaka Metro Rail is a modern mass rapid transit system operated by Dhaka Mass Transit Company Limited (DMTCL). It aims to provide a fast, safe, and eco-friendly transportation solution for the people of Dhaka, reducing congestion and improving urban mobility.</p>
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
        fetch('complaint_handler.php?action=get')
            .then(res => res.json())
            .then(data => {
                renderComplaints(data);
            });
    });

    function renderComplaints(complaints) {
        const tableBody = document.getElementById('complaintTableBody');
        tableBody.innerHTML = '';

        complaints.forEach(complaint => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${complaint.date}</td>
                <td>${complaint.name}</td>
                <td>${complaint.phone_number}</td>
                <td>${complaint.location}</td>
                <td>${complaint.type}</td>
                <td>${complaint.description}</td>
                <td>${complaint.status || 'Pending'}</td>
                <td class="action-buttons">
                    <button class="btn-noted" onclick="markAsNoted(this, ${complaint.complaint_id})">Noted</button>
                    <button class="btn-solve" onclick="solveComplaint(this, ${complaint.complaint_id})">Solve</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    function markAsNoted(button, id) {
        fetch(`complaint_handler.php?action=update&id=${id}&status=Noted`)
            .then(res => res.text())
            .then(response => {
                alert(response);
                button.classList.add('noted');
                button.textContent = '✓ Noted';
                button.closest('tr').querySelector('td:nth-child(7)').textContent = 'Noted';
            });
    }

    function solveComplaint(button, id) {
        if (confirm('Are you sure you want to mark this complaint as solved?')) {
            fetch(`complaint_handler.php?action=update&id=${id}&status=Solved`)
                .then(res => res.text())
                .then(response => {
                    alert(response);
                    button.closest('tr').querySelector('td:nth-child(7)').textContent = 'Solved';
                });
        }
    }

  </script>
</body>
</html>
