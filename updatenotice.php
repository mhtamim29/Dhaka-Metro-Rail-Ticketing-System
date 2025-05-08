<?php
$requireAdmin = true;
include 'session_check.php';

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "metro_ticketing_system_schema";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    // Add new notice
    if ($action == 'add') {
        $title = $conn->real_escape_string($_POST['noticeTitle']);
        $category = $conn->real_escape_string($_POST['noticeCategory']);
        $content = $conn->real_escape_string($_POST['noticeContent']);
        $priority = $conn->real_escape_string($_POST['noticePriority']);
        $expiry = $conn->real_escape_string($_POST['noticeExpiry']);
        
        $sql = "INSERT INTO notices (title, category, content, date, priority, expiry_date) 
                VALUES ('$title', '$category', '$content', CURDATE(), '$priority', '$expiry')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Notice added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
        }
        exit;
    }
    
    // Update existing notice
    elseif ($action == 'update') {
        $id = (int)$_POST['noticeId'];
        $title = $conn->real_escape_string($_POST['noticeTitle']);
        $category = $conn->real_escape_string($_POST['noticeCategory']);
        $content = $conn->real_escape_string($_POST['noticeContent']);
        $priority = $conn->real_escape_string($_POST['noticePriority']);
        $expiry = $conn->real_escape_string($_POST['noticeExpiry']);
        
        $sql = "UPDATE notices SET 
                title = '$title', 
                category = '$category', 
                content = '$content', 
                priority = '$priority',
                expiry_date = '$expiry'
                WHERE notice_id = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Notice updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
        }
        exit;
    }
    
    // Delete notice
    elseif ($action == 'delete') {
        $id = (int)$_POST['noticeId'];
        
        $sql = "DELETE FROM notices WHERE notice_id = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Notice deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
        }
        exit;
    }
    
    // Get single notice for editing
    elseif ($action == 'getNotice') {
        $id = (int)$_POST['noticeId'];
        
        $sql = "SELECT * FROM notices WHERE notice_id = $id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $notice = $result->fetch_assoc();
            echo json_encode(['status' => 'success', 'notice' => $notice]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Notice not found']);
        }
        exit;
    }
}

// Get all notices for display
$currentFilter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$whereClause = $currentFilter != 'all' ? "WHERE category = '$currentFilter'" : "";

$sql = "SELECT * FROM notices $whereClause ORDER BY date DESC";
$result = $conn->query($sql);

$notices = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
}

$conn->close();
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
    <link rel="stylesheet" href="css/updatenotice.css">
    <link rel="stylesheet" href="css/Footer.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        <!-- Card for Adding New Notice -->
        <div class="card">
            <h2 id="noticeHeader">Add New Notice</h2>
            <form id="addNoticeForm">
                <input type="hidden" id="noticeId" name="noticeId" value="">
                <input type="hidden" id="formAction" name="action" value="add">
                
                <div class="form-group">
                    <label for="noticeTitle">Title</label>
                    <input type="text" id="noticeTitle" name="noticeTitle" required>
                </div>
                
                <div class="form-group">
                    <label for="noticeCategory">Category</label>
                    <select id="noticeCategory" name="noticeCategory" required>
                        <option value="">Select a category</option>
                        <option value="schedule">Schedule Change</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="safety">Safety Notice</option>
                        <option value="general">General Announcement</option>
                        <option value="lost & found">Lost & Found</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="noticeContent">Content</label>
                    <textarea id="noticeContent" name="noticeContent" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="noticeExpiry">Expiry Date</label>
                    <input type="date" id="noticeExpiry" name="noticeExpiry" required>
                </div>
                
                <div class="form-group">
                    <label for="noticePriority">Priority</label>
                    <select id="noticePriority" name="noticePriority" required>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                
                <button type="submit" id="submitBtn" class="btn">Publish Notice</button>
                <button type="button" id="cancelBtn" class="btn btn-secondary" style="display:none;">Cancel</button>
            </form>
        </div>

        <!-- Card for Notice Table -->
        <div class="card">
            <h2>Update Notices</h2>
            
            <div class="filter-tabs">
                <a href="updatenotice.php?filter=all" class="tab-btn <?php echo $currentFilter == 'all' ? 'active' : ''; ?>">All</a>
                <a href="updatenotice.php?filter=general" class="tab-btn <?php echo $currentFilter == 'general' ? 'active' : ''; ?>">General</a>
                <a href="updatenotice.php?filter=<?php echo urlencode('lost & found'); ?>" class="tab-btn <?php echo $currentFilter == 'lost & found' ? 'active' : ''; ?>">Lost & Found</a>
                <a href="updatenotice.php?filter=schedule" class="tab-btn <?php echo $currentFilter == 'schedule' ? 'active' : ''; ?>">Schedule</a>
                <a href="updatenotice.php?filter=safety" class="tab-btn <?php echo $currentFilter == 'safety' ? 'active' : ''; ?>">Safety</a>
                <a href="updatenotice.php?filter=maintenance" class="tab-btn <?php echo $currentFilter == 'maintenance' ? 'active' : ''; ?>">Maintenance</a>
            </div>

            <table class="notice-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Content</th>
                        <th>Priority</th>
                        <th>Expiry</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="noticeTableBody">
                    <?php foreach($notices as $notice): ?>
                    <tr data-id="<?php echo $notice['notice_id']; ?>">
                        <td><?php echo date('d/m/Y', strtotime($notice['date'])); ?></td>
                        <td><?php echo htmlspecialchars($notice['title']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($notice['category'])); ?></td>
                        <td><?php echo htmlspecialchars($notice['content']); ?></td>
                        <td><?php echo htmlspecialchars($notice['priority']); ?></td>
                        <td><?php echo isset($notice['expiry_date']) ? date('d/m/Y', strtotime($notice['expiry_date'])) : 'N/A'; ?></td>
                        <td class="action-buttons">
                            <button class="btn-edit" onclick="editNotice(<?php echo $notice['notice_id']; ?>)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn-delete" onclick="deleteNotice(<?php echo $notice['notice_id']; ?>)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($notices)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">No notices found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
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
                <p>Contact Us</a></p>
                </p>FAQs</a></p>
                <p>Terms & Conditions</a></p>
                <p>Privacy Policy</a></p>
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
        function getCategoryName(category) {
            const categories = {
                'schedule': 'Schedule Change',
                'maintenance': 'Maintenance',
                'safety': 'Safety Notice',
                'general': 'General Announcement',
                'lost & found': 'Lost & Found'
            };
            return categories[category] || category;
        }
        
        function editNotice(id) {
            // Change form action to update
            $('#noticeHeader').text('Update Notice');
            $('#formAction').val('update');
            $('#noticeId').val(id);
            $('#submitBtn').text('Update Notice');
            $('#cancelBtn').show();
            
            // Fetch notice details
            $.ajax({
                url: 'updatenotice.php',
                type: 'POST',
                data: {
                    action: 'getNotice',
                    noticeId: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const notice = response.notice;
                        
                        // Populate form
                        $('#noticeTitle').val(notice.title);
                        $('#noticeCategory').val(notice.category);
                        $('#noticeContent').val(notice.content);
                        $('#noticePriority').val(notice.priority);
                        
                        // Format date for input field (YYYY-MM-DD)
                        if (notice.expiry_date) {
                            const parts = notice.expiry_date.split('-');
                            $('#noticeExpiry').val(notice.expiry_date);
                        }
                        
                        // Scroll to form
                        $('html, body').animate({
                            scrollTop: $("#addNoticeForm").offset().top - 150
                        }, 500);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error: Could not retrieve notice details');
                }
            });
        }
        
        function deleteNotice(id) {
            if (confirm('Are you sure you want to delete this notice?')) {
                $.ajax({
                    url: 'updatenotice.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        noticeId: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Notice deleted successfully');
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error: Could not delete notice');
                    }
                });
            }
        }
        
        $(document).ready(function() {
            // Form submission
            $('#addNoticeForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: 'updatenotice.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error: Could not process your request');
                    }
                });
            });
            
            // Cancel button action
            $('#cancelBtn').on('click', function() {
                // Reset form
                $('#noticeHeader').text('Add New Notice');
                $('#addNoticeForm')[0].reset();
                $('#formAction').val('add');
                $('#noticeId').val('');
                $('#submitBtn').text('Publish Notice');
                $(this).hide();
            });
        });
    </script>
</body>
</html>