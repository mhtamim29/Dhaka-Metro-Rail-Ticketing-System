<?php
$requireAdmin = false; // Only normal users can access
include 'session_check.php';
$name = htmlspecialchars($_SESSION['full_name']);
$email = htmlspecialchars($_SESSION['email']);
$phone = htmlspecialchars($_SESSION['phone_number']);

$stations = [
    "uttara-north", "uttara-center", "uttara-south", "pallabi", "mirpur-11",
    "mirpur-10", "kazipara", "shewrapara", "agargaon", "bijoy-sarani",
    "farmgate", "karwan-bazar", "shahbagh", "dhaka-university",
    "bangladesh-secretariat", "motijheel"
];

// Fare matrix
$fareMatrix = [
    "uttara-north" => ["uttara-north"=>0,"uttara-center"=>20,"uttara-south"=>20,"pallabi"=>30,"mirpur-11"=>30,"mirpur-10"=>40,"kazipara"=>40,"shewrapara"=>50,"agargaon"=>60,"bijoy-sarani"=>60,"farmgate"=>70,"karwan-bazar"=>80,"shahbagh"=>80,"dhaka-university"=>90,"bangladesh-secretariat"=>90,"motijheel"=>100],
    "uttara-center" => ["uttara-north"=>20,"uttara-center"=>0,"uttara-south"=>20,"pallabi"=>20,"mirpur-11"=>30,"mirpur-10"=>30,"kazipara"=>40,"shewrapara"=>40,"agargaon"=>50,"bijoy-sarani"=>60,"farmgate"=>60,"karwan-bazar"=>70,"shahbagh"=>80,"dhaka-university"=>90,"bangladesh-secretariat"=>90,"motijheel"=>100],
    "uttara-south" => ["uttara-north"=>20,"uttara-center"=>20,"uttara-south"=>0,"pallabi"=>20,"mirpur-11"=>20,"mirpur-10"=>30,"kazipara"=>30,"shewrapara"=>40,"agargaon"=>40,"bijoy-sarani"=>50,"farmgate"=>60,"karwan-bazar"=>60,"shahbagh"=>70,"dhaka-university"=>80,"bangladesh-secretariat"=>80,"motijheel"=>90],
    "pallabi" => ["uttara-north"=>30,"uttara-center"=>20,"uttara-south"=>20,"pallabi"=>0,"mirpur-11"=>20,"mirpur-10"=>20,"kazipara"=>20,"shewrapara"=>30,"agargaon"=>30,"bijoy-sarani"=>40,"farmgate"=>50,"karwan-bazar"=>50,"shahbagh"=>60,"dhaka-university"=>60,"bangladesh-secretariat"=>70,"motijheel"=>80],
    "mirpur-11" => ["uttara-north"=>30,"uttara-center"=>30,"uttara-south"=>20,"pallabi"=>20,"mirpur-11"=>0,"mirpur-10"=>20,"kazipara"=>20,"shewrapara"=>20,"agargaon"=>30,"bijoy-sarani"=>40,"farmgate"=>40,"karwan-bazar"=>50,"shahbagh"=>50,"dhaka-university"=>60,"bangladesh-secretariat"=>60,"motijheel"=>70],
    "mirpur-10" => ["uttara-north"=>40,"uttara-center"=>30,"uttara-south"=>30,"pallabi"=>20,"mirpur-11"=>20,"mirpur-10"=>0,"kazipara"=>20,"shewrapara"=>20,"agargaon"=>20,"bijoy-sarani"=>30,"farmgate"=>30,"karwan-bazar"=>40,"shahbagh"=>50,"dhaka-university"=>50,"bangladesh-secretariat"=>60,"motijheel"=>60],
    "kazipara" => ["uttara-north"=>40,"uttara-center"=>40,"uttara-south"=>30,"pallabi"=>20,"mirpur-11"=>20,"mirpur-10"=>20,"kazipara"=>0,"shewrapara"=>20,"agargaon"=>20,"bijoy-sarani"=>20,"farmgate"=>30,"karwan-bazar"=>40,"shahbagh"=>40,"dhaka-university"=>50,"bangladesh-secretariat"=>50,"motijheel"=>60],
    "shewrapara" => ["uttara-north"=>50,"uttara-center"=>40,"uttara-south"=>40,"pallabi"=>30,"mirpur-11"=>20,"mirpur-10"=>20,"kazipara"=>20,"shewrapara"=>0,"agargaon"=>20,"bijoy-sarani"=>20,"farmgate"=>20,"karwan-bazar"=>30,"shahbagh"=>40,"dhaka-university"=>40,"bangladesh-secretariat"=>50,"motijheel"=>50],
    "agargaon" => ["uttara-north"=>60,"uttara-center"=>50,"uttara-south"=>40,"pallabi"=>30,"mirpur-11"=>30,"mirpur-10"=>20,"kazipara"=>20,"shewrapara"=>20,"agargaon"=>0,"bijoy-sarani"=>20,"farmgate"=>20,"karwan-bazar"=>20,"shahbagh"=>30,"dhaka-university"=>30,"bangladesh-secretariat"=>40,"motijheel"=>50],
    "bijoy-sarani" => ["uttara-north"=>60,"uttara-center"=>60,"uttara-south"=>50,"pallabi"=>40,"mirpur-11"=>40,"mirpur-10"=>30,"kazipara"=>20,"shewrapara"=>20,"agargaon"=>20,"bijoy-sarani"=>0,"farmgate"=>20,"karwan-bazar"=>20,"shahbagh"=>20,"dhaka-university"=>30,"bangladesh-secretariat"=>40,"motijheel"=>40],
    "farmgate" => ["uttara-north"=>70,"uttara-center"=>60,"uttara-south"=>60,"pallabi"=>50,"mirpur-11"=>40,"mirpur-10"=>40,"kazipara"=>30,"shewrapara"=>20,"agargaon"=>30,"bijoy-sarani"=>20,"farmgate"=>0,"karwan-bazar"=>20,"shahbagh"=>20,"dhaka-university"=>20,"bangladesh-secretariat"=>30,"motijheel"=>30],
    "karwan-bazar" => ["uttara-north"=>80,"uttara-center"=>70,"uttara-south"=>60,"pallabi"=>50,"mirpur-11"=>50,"mirpur-10"=>40,"kazipara"=>40,"shewrapara"=>30,"agargaon"=>20,"bijoy-sarani"=>20,"farmgate"=>20,"karwan-bazar"=>0,"shahbagh"=>20,"dhaka-university"=>20,"bangladesh-secretariat"=>20,"motijheel"=>30],
    "shahbagh" => ["uttara-north"=>80,"uttara-center"=>80,"uttara-south"=>70,"pallabi"=>60,"mirpur-11"=>50,"mirpur-10"=>50,"kazipara"=>40,"shewrapara"=>40,"agargaon"=>30,"bijoy-sarani"=>20,"farmgate"=>30,"karwan-bazar"=>20,"shahbagh"=>0,"dhaka-university"=>20,"bangladesh-secretariat"=>20,"motijheel"=>20],
    "dhaka-university" => ["uttara-north"=>90,"uttara-center"=>80,"uttara-south"=>70,"pallabi"=>60,"mirpur-11"=>60,"mirpur-10"=>50,"kazipara"=>50,"shewrapara"=>40,"agargaon"=>30,"bijoy-sarani"=>30,"farmgate"=>20,"karwan-bazar"=>20,"shahbagh"=>20,"dhaka-university"=>0,"bangladesh-secretariat"=>20,"motijheel"=>20],
    "bangladesh-secretariat" => ["uttara-north"=>90,"uttara-center"=>90,"uttara-south"=>80,"pallabi"=>70,"mirpur-11"=>70,"mirpur-10"=>60,"kazipara"=>50,"shewrapara"=>50,"agargaon"=>40,"bijoy-sarani"=>40,"farmgate"=>30,"karwan-bazar"=>20,"shahbagh"=>20,"dhaka-university"=>20,"bangladesh-secretariat"=>0,"motijheel"=>20],
    "motijheel" => ["uttara-north"=>100,"uttara-center"=>90,"uttara-south"=>90,"pallabi"=>80,"mirpur-11"=>70,"mirpur-10"=>60,"kazipara"=>60,"shewrapara"=>50,"agargaon"=>50,"bijoy-sarani"=>40,"farmgate"=>30,"karwan-bazar"=>30,"shahbagh"=>20,"dhaka-university"=>20,"bangladesh-secretariat"=>20,"motijheel"=>0]
];

$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';
$fare = null;

if ($from && $to && isset($fareMatrix[$from][$to])) {
    $fare = $fareMatrix[$from][$to];
}

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
    <link rel="stylesheet" href="css/buyticket.css">
    <link rel="stylesheet" href="css/Footer.css">
    <style>
        /* Additional styles for fare card */
        .fare-card {
            background-color: #f0f8f4;
            border: 1px solid #006a4e;
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .metro-icon {
            width: 70px;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .station-route {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }
        
        .fare-amount {
            font-size: 32px;
            font-weight: bold;
            margin: 15px 0;
            color: #006a4e;
        }
        
        .metro-label {
            color: #666;
            font-size: 16px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
          <div class="logo">
            <img src="picture/logo.png" alt="Dhaka Metro Rail" />
          </div>
          <button class="hamburger-btn" id="menu-toggle" aria-label="Toggle menu" aria-expanded="false">
            <i class="fas fa-bars"></i>
          </button>
          <nav>
          <ul class="nav-links">
                    <li><a href="home.php">HOME</a></li>
                    <li><a href="buyticket.php">BUY TICKET</a></li>
                    <li><a href="help&support.php">HELP & SUPPORT</a></li>
                    <li><a href="myticket.php">MY TICKETS</a></li>
                    <li><a href="travelhistory.php">TRAVEL HISTORY</a></li>
                    <li><a href="profile.php">PROFILE</a></li>
                </ul>
          </nav>
        </div>
      </header>

    <!-- buy tickets -->
    <buyticktes style="padding-top: 120px;padding-bottom: 30px;" class="container">
    <div class="card">
            <h2>Buy Ticket</h2>
            <form id="journey-form" method="POST" action="buyticket.php">
                <div class="form-group">
                    <div>
                        <label style="font-size: larger;" for="from"><strong>From</strong></label>
                        <select id="from" name="from" class="form-control" style="margin-top: 0.5rem;" required>
                            <option value="" disabled <?= empty($from) ? 'selected' : '' ?>>Select Your Station</option>
                            <?php foreach ($stations as $station): ?>
                                <option value="<?= $station ?>" <?= ($from === $station) ? 'selected' : '' ?>>
                                    <?= ucwords(str_replace('-', ' ', $station)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: larger;" for="to"><strong>To</strong></label>
                        <select id="to" name="to" class="form-control" style="margin-top: 0.5rem;" required>
                            <option value="" disabled <?= empty($to) ? 'selected' : '' ?>>Select Your Station</option>
                            <?php foreach ($stations as $station): ?>
                                <option value="<?= $station ?>" <?= ($to === $station) ? 'selected' : '' ?>>
                                    <?= ucwords(str_replace('-', ' ', $station)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button style="display: flex; justify-content: center; align-items: center; width: 100%;height: 47px;
                background-color: #006a4e; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-size: 16px; cursor: pointer;"
                type="submit" id="calculate-fare" class="btn btn-large"><strong>Calculate Fare</strong></button>
            </form>
            
            <?php if (!is_null($fare)): ?>
                <div class="fare-card">
                    <img src="picture/logo.png" alt="Metro" class="metro-icon">
                    <div class="station-route">
                        <?= ucwords(str_replace('-', ' ', $from)) ?> → <?= ucwords(str_replace('-', ' ', $to)) ?>
                    </div>
                    <div class="fare-amount"><?= $fare ?> Taka</div>
                    <div class="metro-label">Dhaka Metro Rail Fare</div>
                </div>
                
                <form method="POST" action="buy_ticket_handler.php" id="payment-form">
                    <input type="hidden" name="from" value="<?= $from ?>">
                    <input type="hidden" name="to" value="<?= $to ?>">
                    <input type="hidden" name="fare" value="<?= $fare ?>">
                    
                    <div class="payment-options">
                        <h2 style="color: #006a4e;text-align: center;">Payment Method</h2>
                        <div class="payment-option">
                            <input type="radio" id="mobileBanking" name="payment_method" value="Mobile Banking" required>
                            <label for="mobileBanking">Pay with Mobile Banking</label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="banking" name="payment_method" value="Banking" required>
                            <label for="banking">Pay with Banking</label>
                        </div>
                        
                        <!-- Mobile Banking Form -->
                        <div class="payment-form" id="mobileBankingForm" style="display: none;">
                            <h2 style="color: #006a4e;text-align: center;">Mobile Banking Payment</h2>
                            
                            <div class="mobile-banking-options">
                                <div class="bank-option" data-bank="bkash">
                                    <img src="picture/bkash.svg" alt="bKash">
                                    <span>bKash</span>
                                </div>
                                <div class="bank-option" data-bank="rocket">
                                    <img src="picture/dutch-bangla-rocket-logo-png_seeklogo-317692.png" alt="Rocket">
                                    <span>Rocket</span>
                                </div>
                                <div class="bank-option" data-bank="nagad">
                                    <img src="picture/Nagad-Vertical-Logo.wine.svg" alt="Nagad">
                                    <span>Nagad</span>
                                </div>
                                <div class="bank-option" data-bank="upay">
                                    <img src="picture/upay.png" alt="Upay">
                                    <span>Upay</span>
                                </div>
                            </div>
                    
                            <div class="form-group">
                                <div>
                                    <label for="mobile-number">Account Number</label>
                                    <input type="tel" id="mobile-number" name="mobile_number" placeholder="+8801 XXXXXXXXX">
                                </div>
                                <div>
                                    <label for="mobile-amount">Amount</label>
                                    <input type="text" id="mobile-amount" name="amount" value="<?= $fare ?>" readonly>
                                </div>
                                <div>
                                    <label for="mobile-pin">PIN Number</label>
                                    <input type="password" id="mobile-pin" name="pin" placeholder="Enter your PIN">
                                </div>
                                <textarea name="payment_info" id="payment_info_mobile" style="display: none;"></textarea>
                            </div>
                        </div>
                        
                        <!-- Banking Form -->
                        <div class="payment-form" id="bankingForm" style="display: none;">
                            <h3 style="color: #006a4e;text-align: center;">Banking Payment</h3>
                            
                            <div class="banking-options">
                                <div class="bank-card-option" data-card="visa">
                                    <img src="picture/Visa-Logo-2006.png" alt="Visa">
                                    <span>Visa</span>
                                </div>
                                <div class="bank-card-option" data-card="mastercard">
                                    <img src="picture/png-clipart-mastercard-credit-card-mastercard-logo-mastercard-logo-love-text.png" alt="Mastercard">
                                    <span>Mastercard</span>
                                </div>
                                <div class="bank-card-option" data-card="amex">
                                    <img src="picture/png-clipart-american-express-logo-credit-card-payment-credit-card-blue-text.png" alt="American Express">
                                    <span>Amex</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div>
                                    <label for="account-number">Card Number</label>
                                    <input type="text" id="account-number" name="card_number" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="card-details-grid">
                                    <div>
                                        <label for="card-name">Cardholder Name</label>
                                        <input type="text" id="card-name" name="card_name" placeholder="Name on card">
                                    </div>
                                    <div class="expiry-cvv">
                                        <div>
                                            <label for="MM">Expiry Date</label>
                                            <input type="text" id="MM" name="expiry" placeholder="MM/YY">
                                        </div>
                                        <div>
                                            <label for="CVV">CVV/CVC</label>
                                            <input type="text" id="CVV" name="cvv" placeholder="123">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="bank-amount">Amount</label>
                                    <input type="text" id="bank-amount" name="amount_bank" value="<?= $fare ?>" readonly>
                                </div>
                                <div>
                                    <label for="bank-pin">PIN Number</label>
                                    <input type="password" id="bank-pin" name="bank_pin" placeholder="Enter your PIN">
                                </div>
                                <textarea name="payment_info" id="payment_info_bank" style="display: none;"></textarea>
                            </div>
                        </div>
                        
                        <div class="payment-actions">
                            <button style="width: 300px;" type="button" class="btn btn-cancel">Cancel</button>
                            <button style="width: 300px;background-color: #006a4e" type="submit" class="btn btn-confirm">Confirm Payment</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
            </div>
        </buyticktes>
    
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
        document.addEventListener('DOMContentLoaded', function(){
            // Toggle mobile menu
            const menuToggle = document.getElementById('menu-toggle');
            const navLinks = document.querySelector('.nav-links');
            
            if(menuToggle && navLinks) {
                menuToggle.addEventListener('click', function() {
                    navLinks.classList.toggle('show');
                    const expanded = menuToggle.getAttribute('aria-expanded') === 'true' || false;
                    menuToggle.setAttribute('aria-expanded', !expanded);
                });
            }

            // Validate same station selection
            const cal_button = document.getElementById("calculate-fare");
            if(cal_button) {
                cal_button.addEventListener("click", function(e){
                    const from_value = document.getElementById("from").value;
                    const to_value = document.getElementById("to").value;

                    if(from_value && to_value && from_value == to_value) {
                        e.preventDefault();
                        alert("Departure and arrival stations cannot be the same.");
                    }
                });
            }
            
            // Payment method handling
            const mobileBankingRadio = document.getElementById('mobileBanking');
            const bankingRadio = document.getElementById('banking');
            const mobileBankingForm = document.getElementById('mobileBankingForm');
            const bankingForm = document.getElementById('bankingForm');
            
            // Mobile banking fields
            const mobileNumber = document.getElementById('mobile-number');
            const mobilePin = document.getElementById('mobile-pin');
            
            // Banking fields
            const accountNumber = document.getElementById('account-number');
            const cardName = document.getElementById('card-name');
            const expiry = document.getElementById('MM');
            const cvv = document.getElementById('CVV');
            const bankPin = document.getElementById('bank-pin');

            // Function to update field requirements
            function updateFieldRequirements() {
                if (mobileBankingRadio.checked) {
                    // Make mobile banking fields required
                    mobileNumber.required = true;
                    mobilePin.required = true;
                    
                    // Remove required from banking fields
                    accountNumber.required = false;
                    cardName.required = false;
                    expiry.required = false;
                    cvv.required = false;
                    bankPin.required = false;
                    
                    // Show mobile banking form, hide banking form
                    if(mobileBankingForm) mobileBankingForm.style.display = 'block';
                    if(bankingForm) bankingForm.style.display = 'none';
                } else if (bankingRadio.checked) {
                    // Make banking fields required
                    accountNumber.required = true;
                    cardName.required = true;
                    expiry.required = true;
                    cvv.required = true;
                    bankPin.required = true;
                    
                    // Remove required from mobile banking fields
                    mobileNumber.required = false;
                    mobilePin.required = false;
                    
                    // Show banking form, hide mobile banking form
                    if(bankingForm) bankingForm.style.display = 'block';
                    if(mobileBankingForm) mobileBankingForm.style.display = 'none';
                }
            }

            // Set up payment method change listeners
            if(mobileBankingRadio && bankingRadio) {
                mobileBankingRadio.addEventListener('change', updateFieldRequirements);
                bankingRadio.addEventListener('change', updateFieldRequirements);
            }

            // Handle mobile banking options
            const bankOptions = document.querySelectorAll('.bank-option');
            bankOptions.forEach(option => {
                option.addEventListener('click', function() {
                    bankOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    const bankName = this.getAttribute('data-bank');
                    if(document.getElementById('payment_info_mobile')) {
                        document.getElementById('payment_info_mobile').value = 'Selected method: ' + bankName;
                    }
                });
            });
            
            // Handle banking card options
            const bankCardOptions = document.querySelectorAll('.bank-card-option');
            bankCardOptions.forEach(option => {
                option.addEventListener('click', function() {
                    bankCardOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    const cardType = this.getAttribute('data-card');
                    if(document.getElementById('payment_info_bank')) {
                        document.getElementById('payment_info_bank').value = 'Selected card: ' + cardType;
                    }
                });
            });

            // Cancel button functionality
            const cancelBtn = document.querySelector('.btn-cancel');
            if(cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    window.location.href = 'buyticket.php';
                });
            }

            // Form submission validation
            const paymentForm = document.getElementById('payment-form');
            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    if (!mobileBankingRadio.checked && !bankingRadio.checked) {
                        e.preventDefault();
                        alert('Please select a payment method.');
                        return;
                    }

                    if (mobileBankingRadio.checked) {
                        // Validate mobile banking fields
                        if (!mobileNumber.value || !mobilePin.value) {
                            e.preventDefault();
                            alert('Please fill all required fields for Mobile Banking payment.');
                        }
                    } else if (bankingRadio.checked) {
                        // Validate banking fields
                        if (!accountNumber.value || !cardName.value || !expiry.value || !cvv.value || !bankPin.value) {
                            e.preventDefault();
                            alert('Please fill all required fields for Banking payment.');
                        }
                    }
                });
            }

            <?php if ($fare): ?>
            // Scroll to fare card if it's visible
            setTimeout(() => {
                document.querySelector('.fare-card').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 100);
            <?php endif; ?>
        });
    </script>
</body>
</html>
