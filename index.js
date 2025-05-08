// drop down menu.js
function toggleMenu() {
    var menu = document.getElementById("dropdownMenu");
    menu.classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.closest('.dropdown')) {
        var dropdowns = document.getElementsByClassName("dropdown-menu");
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].classList.remove('show');
        }
    }
}


// hero section video js
                // Video fallback detection
                document.addEventListener('DOMContentLoaded', function() {
                    const video = document.getElementById('hero-video');
                    const heroSection = document.querySelector('.hero');
                    
                    // Check if video can play
                    const canPlay = video.canPlayType('video/mp4');
                    if (canPlay === '') {
                        heroSection.classList.add('no-video');
                    } else {
                        video.play().catch(error => {
                            // If video fails to play, show fallback
                            heroSection.classList.add('no-video');
                        });
                    }
                });

// metroFareCalculator.js
document.addEventListener('DOMContentLoaded', function() {
    const fareMatrix = {
        'uttara-north': {
            'uttara-north': 0,
            'uttara-center': 20,
            'uttara-south': 20,
            'pallabi': 30,
            'mirpur-11': 30,
            'mirpur-10': 40,
            'kazipara': 40,
            'shewrapara': 50,
            'agargaon': 60,
            'bijoy-sarani': 60,
            'farmgate': 70,
            'karwan-bazar': 80,
            'shahbagh': 80,
            'dhaka-university': 90,
            'bangladesh-secretariat': 90,
            'motijheel': 100
        },
        'uttara-center': {
            'uttara-north': 20,
            'uttara-center': 0,
            'uttara-south': 20,
            'pallabi': 20,
            'mirpur-11': 30,
            'mirpur-10': 30,
            'kazipara': 40,
            'shewrapara': 40,
            'agargaon': 50,
            'bijoy-sarani': 60,
            'farmgate': 60,
            'karwan-bazar': 70,
            'shahbagh': 80,
            'dhaka-university': 90,
            'bangladesh-secretariat': 90,
            'motijheel': 100
        },
        'uttara-south': {
            'uttara-north': 20,
            'uttara-center': 20,
            'uttara-south': 0,
            'pallabi': 20,
            'mirpur-11': 20,
            'mirpur-10': 30,
            'kazipara': 30,
            'shewrapara': 40,
            'agargaon': 40,
            'bijoy-sarani': 50,
            'farmgate': 60,
            'karwan-bazar': 60,
            'shahbagh': 70,
            'dhaka-university': 80,
            'bangladesh-secretariat': 80,
            'motijheel': 90
        },
        'pallabi': {
            'uttara-north': 30,
            'uttara-center': 20,
            'uttara-south': 20,
            'pallabi': 0,
            'mirpur-11': 20,
            'mirpur-10': 20,
            'kazipara': 20,
            'shewrapara': 30,
            'agargaon': 30,
            'bijoy-sarani': 40,
            'farmgate': 50,
            'karwan-bazar': 50,
            'shahbagh': 60,
            'dhaka-university': 60,
            'bangladesh-secretariat': 70,
            'motijheel': 80
        },
        'mirpur-11': {
            'uttara-north': 30,
            'uttara-center': 30,
            'uttara-south': 20,
            'pallabi': 20,
            'mirpur-11': 0,
            'mirpur-10': 20,
            'kazipara': 20,
            'shewrapara': 20,
            'agargaon': 30,
            'bijoy-sarani': 40,
            'farmgate': 40,
            'karwan-bazar': 50,
            'shahbagh': 50,
            'dhaka-university': 60,
            'bangladesh-secretariat': 60,
            'motijheel': 70
        },
        'mirpur-10': {
            'uttara-north': 40,
            'uttara-center': 30,
            'uttara-south': 30,
            'pallabi': 20,
            'mirpur-11': 20,
            'mirpur-10': 0,
            'kazipara': 20,
            'shewrapara': 20,
            'agargaon': 20,
            'bijoy-sarani': 30,
            'farmgate': 30,
            'karwan-bazar': 40,
            'shahbagh': 50,
            'dhaka-university': 50,
            'bangladesh-secretariat': 60,
            'motijheel': 60
        },
        'kazipara': {
            'uttara-north': 40,
            'uttara-center': 40,
            'uttara-south': 30,
            'pallabi': 20,
            'mirpur-11': 20,
            'mirpur-10': 20,
            'kazipara': 0,
            'shewrapara': 20,
            'agargaon': 20,
            'bijoy-sarani': 20,
            'farmgate': 30,
            'karwan-bazar': 40,
            'shahbagh': 40,
            'dhaka-university': 50,
            'bangladesh-secretariat': 50,
            'motijheel': 60
        },
        'shewrapara': {
            'uttara-north': 50,
            'uttara-center': 40,
            'uttara-south': 40,
            'pallabi': 30,
            'mirpur-11': 20,
            'mirpur-10': 20,
            'kazipara': 20,
            'shewrapara': 0,
            'agargaon': 20,
            'bijoy-sarani': 20,
            'farmgate': 20,
            'karwan-bazar': 30,
            'shahbagh': 40,
            'dhaka-university': 40,
            'bangladesh-secretariat': 50,
            'motijheel': 50
        },
        'agargaon': {
            'uttara-north': 60,
            'uttara-center': 50,
            'uttara-south': 40,
            'pallabi': 30,
            'mirpur-11': 30,
            'mirpur-10': 20,
            'kazipara': 20,
            'shewrapara': 20,
            'agargaon': 0,
            'bijoy-sarani': 20,
            'farmgate': 20,
            'karwan-bazar': 20,
            'shahbagh': 30,
            'dhaka-university': 30,
            'bangladesh-secretariat': 40,
            'motijheel': 50
        },
        'bijoy-sarani': {
            'uttara-north': 60,
            'uttara-center': 60,
            'uttara-south': 50,
            'pallabi': 40,
            'mirpur-11': 40,
            'mirpur-10': 30,
            'kazipara': 20,
            'shewrapara': 20,
            'agargaon': 20,
            'bijoy-sarani': 0,
            'farmgate': 20,
            'karwan-bazar': 20,
            'shahbagh': 20,
            'dhaka-university': 30,
            'bangladesh-secretariat': 40,
            'motijheel': 40
        },
        'farmgate': {
            'uttara-north': 70,
            'uttara-center': 60,
            'uttara-south': 60,
            'pallabi': 50,
            'mirpur-11': 40,
            'mirpur-10': 40,
            'kazipara': 30,
            'shewrapara': 20,
            'agargaon': 30,
            'bijoy-sarani': 20,
            'farmgate': 0,
            'karwan-bazar': 20,
            'shahbagh': 20,
            'dhaka-university': 20,
            'bangladesh-secretariat': 30,
            'motijheel': 30
        },
        'karwan-bazar': {
            'uttara-north': 80,
            'uttara-center': 70,
            'uttara-south': 60,
            'pallabi': 50,
            'mirpur-11': 50,
            'mirpur-10': 40,
            'kazipara': 40,
            'shewrapara': 30,
            'agargaon': 20,
            'bijoy-sarani': 20,
            'farmgate': 20,
            'karwan-bazar': 0,
            'shahbagh': 20,
            'dhaka-university': 20,
            'bangladesh-secretariat': 20,
            'motijheel': 30
        },
        'shahbagh': {
            'uttara-north': 80,
            'uttara-center': 80,
            'uttara-south': 70,
            'pallabi': 60,
            'mirpur-11': 50,
            'mirpur-10': 50,
            'kazipara': 40,
            'shewrapara': 40,
            'agargaon': 30,
            'bijoy-sarani': 20,
            'farmgate': 30,
            'karwan-bazar': 20,
            'shahbagh': 0,
            'dhaka-university': 20,
            'bangladesh-secretariat': 20,
            'motijheel': 20
        },
        'dhaka-university': {
            'uttara-north': 90,
            'uttara-center': 80,
            'uttara-south': 70,
            'pallabi': 60,
            'mirpur-11': 60,
            'mirpur-10': 50,
            'kazipara': 50,
            'shewrapara': 40,
            'agargaon': 30,
            'bijoy-sarani': 30,
            'farmgate': 20,
            'karwan-bazar': 20,
            'shahbagh': 20,
            'dhaka-university': 0,
            'bangladesh-secretariat': 20,
            'motijheel': 20
        },
        'bangladesh-secretariat': {
            'uttara-north': 90,
            'uttara-center': 90,
            'uttara-south': 80,
            'pallabi': 70,
            'mirpur-11': 70,
            'mirpur-10': 60,
            'kazipara': 50,
            'shewrapara': 50,
            'agargaon': 40,
            'bijoy-sarani': 40,
            'farmgate': 30,
            'karwan-bazar': 20,
            'shahbagh': 20,
            'dhaka-university': 20,
            'bangladesh-secretariat': 0,
            'motijheel': 20
        },
        'motijheel': {
            'uttara-north': 100,
            'uttara-center': 90,
            'uttara-south': 90,
            'pallabi': 80,
            'mirpur-11': 70,
            'mirpur-10': 60,
            'kazipara': 60,
            'shewrapara': 50,
            'agargaon': 50,
            'bijoy-sarani': 40,
            'farmgate': 30,
            'karwan-bazar': 30,
            'shahbagh': 20,
            'dhaka-university': 20,
            'bangladesh-secretariat': 20,
            'motijheel': 0
        }
    };

    // Calculate fare button click handler
    document.getElementById('calculate-fare').addEventListener('click', function() {
        const fromStation = document.getElementById('from').value;
        const toStation = document.getElementById('to').value;
        
        if (!fromStation || !toStation) {
            alert('Please select both "From" and "To" stations.');
            return;
        }
        
        if (fromStation === toStation) {
            alert('Departure and arrival stations cannot be the same.');
            return;
        }
        
        const fare = fareMatrix[fromStation][toStation];
        const fromName = document.getElementById('from').options[document.getElementById('from').selectedIndex].text;
        const toName = document.getElementById('to').options[document.getElementById('to').selectedIndex].text;
        
        // Display the result
        showFareResult(fromName, toName, fare);
    });

    // Function to display fare result
    function showFareResult(fromName, toName, fare) {
        // Remove any existing result
        const oldResult = document.getElementById('fare-result');
        if (oldResult) oldResult.remove();
        
        // Create result element
        const resultDiv = document.createElement('div');
        resultDiv.id = 'fare-result';
        resultDiv.style.marginTop = '1rem';
        resultDiv.style.padding = '1rem';
        resultDiv.style.backgroundColor = '#f8f9fa';
        resultDiv.style.borderRadius = '5px';
        resultDiv.style.textAlign = 'center';
        
        // Add content
        resultDiv.innerHTML = `
            <div style="font-size: 1.1rem; margin-bottom: 0.5rem;">
                <span style="color: #006a4e;">${fromName}</span> 
                → 
                <span style="color:rgb(204, 0, 0);">${toName}</span>
            </div>
            <div style="font-size: 1.8rem; font-weight: bold; color: #006a4e;">
                ${fare} Taka
            </div>
            <div style="margin-top: 0.5rem; font-size: 0.9rem; color: #666;">
                Dhaka Metro Rail Fare
            </div>
        `;
        
        // Add to the form
        const form = document.getElementById('journey-form');
        form.appendChild(resultDiv);
    }
});


// live metro sedule

document.addEventListener('DOMContentLoaded', function() {
    // Get references to the dropdowns
    const timeSelect = document.querySelector('.schedule-card select:first-of-type');
    const stationSelect = document.querySelector('.schedule-card select:last-of-type');
    const tableBody = document.querySelector('.schedule-card tbody');
    
    const stationOrder = [
        "Uttara North",
        "Uttara Center",
        "Uttara South",
        "Pallabi",
        "Mirpur-11",
        "Mirpur-10",
        "Kazipara",
        "Shewrapara",
        "Agargaon",
        "Bijoy Sarani",
        "Farmgate",
        "Karwan Bazar",
        "Shahbagh",
        "Dhaka University",
        "Bangladesh Secretariat",
        "Motijheel"
    ];
    
    // Time between stations (2 minutes)
    const timeBetweenStations = 2;
    
    // Update the schedule when selections change
    timeSelect.addEventListener('change', updateSchedule);
    stationSelect.addEventListener('change', updateSchedule);
    
    function updateSchedule() {
        const selectedTime = timeSelect.value;
        const selectedStation = stationSelect.value;
        
        if (!selectedTime) return;
        
        // Clear existing rows (but preserve the header)
        while (tableBody.firstChild) {
            tableBody.removeChild(tableBody.firstChild);
        }
        
        // Calculate times for the next 3 trains
        for (let trainNum = 0; trainNum < 3; trainNum++) {
            // Calculate base time for this train (add 20 minutes for each subsequent train)
            const baseTime = addMinutes(selectedTime, trainNum * 20);
            
            // Find the index of the selected station (if one is selected)
            const selectedStationIndex = selectedStation ? 
                stationOrder.findIndex(station => 
                    station.toLowerCase().replace(' ', '-') === selectedStation
                ) : -1;
            
            // Create a new row for each station or just the selected one
            if (selectedStationIndex >= 0) {
                // Only show the selected station
                const stationName = stationOrder[selectedStationIndex];
                const minutesFromStart = (stationOrder.length - 1 - selectedStationIndex) * timeBetweenStations;
                const arrivalTime = subtractMinutes(baseTime, minutesFromStart);
                
                const row = createScheduleRow(
                    trainNum + 1,
                    arrivalTime,
                    addMinutes(arrivalTime, 1) // departure is 1 min after arrival
                );
                tableBody.appendChild(row);
            } else {
                // Show all stations
                stationOrder.forEach((stationName, index) => {
                    const minutesFromStart = (stationOrder.length - 1 - index) * timeBetweenStations;
                    const arrivalTime = subtractMinutes(baseTime, minutesFromStart);
                    
                    const row = createScheduleRow(
                        trainNum + 1,
                        arrivalTime,
                        addMinutes(arrivalTime, 1) // departure is 1 min after arrival
                    );
                    tableBody.appendChild(row);
                });
            }
        }
    }
    
    function createScheduleRow(serialNo, arrivalTime, departureTime) {
        const row = document.createElement('tr');
        row.style.backgroundColor = serialNo % 2 === 1 ? 'var(--white)' : '#f2f2f2';
        
        // Serial number cell
        const serialCell = document.createElement('td');
        serialCell.style.padding = '1rem';
        serialCell.style.textAlign = 'center';
        serialCell.textContent = serialNo;
        row.appendChild(serialCell);
        
        // Arrival time cell
        const arrivalCell = document.createElement('td');
        arrivalCell.style.padding = '1rem';
        arrivalCell.style.textAlign = 'center';
        arrivalCell.textContent = formatTime(arrivalTime);
        row.appendChild(arrivalCell);
        
        // Departure time cell
        const departureCell = document.createElement('td');
        departureCell.style.padding = '1rem';
        departureCell.style.textAlign = 'center';
        departureCell.textContent = formatTime(departureTime);
        row.appendChild(departureCell);
        
        return row;
    }
    
    // Helper function to add minutes to a time string (HH:mm format)
    function addMinutes(timeString, minutesToAdd) {
        const [hours, minutes] = timeString.split(':').map(Number);
        let totalMinutes = hours * 60 + minutes + minutesToAdd;
        
        // Handle overflow to next hour/day
        const newHours = Math.floor(totalMinutes / 60) % 24;
        const newMinutes = totalMinutes % 60;
        
        return `${String(newHours).padStart(2, '0')}:${String(newMinutes).padStart(2, '0')}`;
    }
    
    // Helper function to subtract minutes from a time string
    function subtractMinutes(timeString, minutesToSubtract) {
        const [hours, minutes] = timeString.split(':').map(Number);
        let totalMinutes = hours * 60 + minutes - minutesToSubtract;
        
        // Handle underflow to previous hour/day
        while (totalMinutes < 0) {
            totalMinutes += 24 * 60; // Add a full day
        }
        
        const newHours = Math.floor(totalMinutes / 60) % 24;
        const newMinutes = totalMinutes % 60;
        
        return `${String(newHours).padStart(2, '0')}:${String(newMinutes).padStart(2, '0')}`;
    }
    
    // Helper function to format time (add AM/PM)
    function formatTime(timeString) {
        const [hours, minutes] = timeString.split(':').map(Number);
        const period = hours >= 12 ? 'PM' : 'AM';
        const displayHours = hours % 12 || 12;
        return `${displayHours}:${String(minutes).padStart(2, '0')} ${period}`;
    }
    
    // Initialize the schedule
    updateSchedule();
});

// Select the header and body elements
const header = document.querySelector('header');
const body = document.querySelector('body');

// Event listener for scroll
window.addEventListener('scroll', () => {
    // Check if the page is scrolled down
    if (window.scrollY > 100) {
        header.classList.add('transparent');
        body.classList.add('white-background');
    } else {
        header.classList.remove('transparent');
        body.classList.remove('white-background');
    }
});






        //Login partToggle password visibility
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const showPasswordCheckbox = document.getElementById('showPassword');
            
            showPasswordCheckbox.addEventListener('change', function() {
                passwordInput.type = this.checked ? 'text' : 'password';
            });

            // Dropdown menu toggle (from your original code)
            function toggleMenu() {
                var menu = document.getElementById("dropdownMenu");
                menu.classList.toggle("show");
            }
            
            window.onclick = function(event) {
                if (!event.target.closest('.dropdown')) {
                    var dropdowns = document.getElementsByClassName("dropdown-menu");
                    for (var i = 0; i < dropdowns.length; i++) {
                        dropdowns[i].classList.remove('show');
                    }
                }
            }
        });

//start of addition by nafi
document.addEventListener('DOMContentLoaded', function() {
    // Function to toggle edit mode
    window.toggleEdit = function(fieldId) {
        const field = document.getElementById(fieldId);
        field.disabled = !field.disabled;
        
        if (!field.disabled) {
            field.focus();
        }
    };
    
    // Function to toggle menu
    window.toggleMenu = function() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('show');
    };
    
    // Preview image before upload
    const uploadPic = document.getElementById('uploadPic');
    const profilePic = document.getElementById('profilePic');
    
    if (uploadPic) {
        uploadPic.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});



//end of addition by nafi




// payment method
document.addEventListener('DOMContentLoaded', function() {
    // Get references to payment options and forms
    const mobileBankingRadio = document.getElementById('mobileBanking');
    const bankingRadio = document.getElementById('banking');
    const mobileBankingForm = document.getElementById('mobileBankingForm');
    const bankingForm = document.getElementById('bankingForm');
    const successMessage = document.getElementById('successMessage');
    const viewTicketsBtn = document.getElementById('viewTicketsBtn');
    
    // Initially hide all payment forms and unselect all radio buttons
    mobileBankingForm.style.display = 'none';
    bankingForm.style.display = 'none';
    mobileBankingRadio.checked = false;
    bankingRadio.checked = false;

    // Mobile Banking selection handler
    mobileBankingRadio.addEventListener('change', function() {
        if (this.checked) {
            mobileBankingForm.style.display = 'block';
            bankingForm.style.display = 'none';
            successMessage.style.display = 'none';
        }
    });

    // Banking selection handler
    bankingRadio.addEventListener('change', function() {
        if (this.checked) {
            bankingForm.style.display = 'block';
            mobileBankingForm.style.display = 'none';
            successMessage.style.display = 'none';
        }
    });

    // Mobile banking option selection
    const bankOptions = document.querySelectorAll('.bank-option');
    let selectedBank = null;
    
    bankOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            bankOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            selectedBank = this.getAttribute('data-bank');
        });
    });

    // Banking card option selection
    const bankCardOptions = document.querySelectorAll('.bank-card-option');
    let selectedCard = null;
    
    bankCardOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            bankCardOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            selectedCard = this.getAttribute('data-card');
        });
    });

    // Cancel button handler
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset the form
            const form = this.closest('.payment-form');
            form.querySelectorAll('input').forEach(input => {
                input.value = '';
            });
            
            // Unselect payment method
            mobileBankingRadio.checked = false;
            bankingRadio.checked = false;
            form.style.display = 'none';
            
            // Unselect bank/card options
            bankOptions.forEach(opt => opt.classList.remove('selected'));
            bankCardOptions.forEach(opt => opt.classList.remove('selected'));
            selectedBank = null;
            selectedCard = null;
        });
    });

 // Confirm payment button handler


document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-confirm").forEach(button => {
        button.addEventListener("click", function () {
            let form = this.closest(".payment-form");
            let inputs = form.querySelectorAll("input[type='text'], input[type='tel'], input[type='password']");
            let isValid = true;

            inputs.forEach(input => {
                if (input.value.trim() === "") {
                    isValid = false;
                    input.style.border = "2px solid red"; // Highlight empty fields
                } else {
                    input.style.border = ""; // Reset border if filled
                }
            });

            if (!isValid) {
                alert("⚠ Please fill in all required fields before confirming payment.");
            } else {
                alert("✅ Payment confirmed successfully!");
            }
        });
    });
});


    // View Tickets button handler
    viewTicketsBtn.addEventListener('click', function() {
        // Redirect to My Tickets page
        window.location.href = 'mytickets.html';
    });

    // Your existing toggleMenu function
    function toggleMenu() {
        var menu = document.getElementById("dropdownMenu");
        menu.classList.toggle("show");
    }
    
    window.onclick = function(event) {
        if (!event.target.closest('.dropdown')) {
            var dropdowns = document.getElementsByClassName("dropdown-menu");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.remove('show');
            }
        }
    }
});




        // Toggle edit functionality
        function toggleEdit(fieldId) {
            const inputField = document.getElementById(fieldId);
            inputField.disabled = !inputField.disabled;
            if (!inputField.disabled) {
                inputField.focus();
            }
        }
        
        // Profile picture upload functionality
        document.getElementById('uploadPic').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profilePic').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Save changes functionality
        document.querySelector('.btn').addEventListener('click', function() {
            alert('Profile changes saved successfully');
        });

        // Sign out functionality
        document.getElementById('signOutButton').addEventListener('click', function() {
            if(confirm('Are you sure you want to sign out?')) {
                // Redirect to index.html
                window.location.href = 'index.html';
            }
        });

        // Toggle password visibility
        const showPasswordCheckbox = document.getElementById('showPassword');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');

        showPasswordCheckbox.addEventListener('change', function() {
            const type = this.checked ? 'text' : 'password';
            password.type = type;
            confirmPassword.type = type;
        });


                // Handle form submission
                document.getElementById('loginForm').addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission
                    
                    // Here you would typically validate the credentials
                    // For this example, we'll just redirect after login
                    window.location.href = 'home.html';
                });






                // Handle form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('passwordError');
            
            // Validate password length
            if (password.length < 8) {
                passwordError.style.display = 'block';
                return false;
            } else {
                passwordError.style.display = 'none';
            }
            
            // Here you would typically validate the credentials with server
            // For this example, we'll just redirect after successful validation
            window.location.href = 'home.html';
        });

        // Real-time password validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const passwordError = document.getElementById('passwordError');
            
            if (password.length > 0 && password.length < 8) {
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });


// view all action js
        document.getElementById("viewAllBtn").addEventListener("click", function() {
            window.location.href = "notice.html";
        });


 // Filter notices by type (All/General/Lost)
function filterNotices(type) {
    // Set active tab
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => tab.classList.remove('active'));
    event.target.classList.add('active');
    
    // Get all notice items
    const notices = document.querySelectorAll('.notice-item');
    
    notices.forEach(notice => {
        if (type === 'all') {
            notice.style.display = 'block';
        } else {
            if (notice.classList.contains(type)) {
                notice.style.display = 'block';
            } else {
                notice.style.display = 'none';
            }
        }
    });
    
    // Reset "View More" button if all notices are hidden
    checkViewMoreButton();
}

// Sort notices by date (Newest/Oldest)
function sortNotices(order) {
    const noticesList = document.getElementById('noticesList');
    const notices = Array.from(noticesList.querySelectorAll('.notice-item'));
    
    notices.sort((a, b) => {
        const dateA = new Date(a.querySelector('.notice-date').textContent.split('/').reverse().join('-'));
        const dateB = new Date(b.querySelector('.notice-date').textContent.split('/').reverse().join('-'));
        return order === 'newest' ? dateB - dateA : dateA - dateB;
    });
    
    // Reattach sorted notices
    notices.forEach(notice => noticesList.appendChild(notice));
}

// Show more notices when "View More" is clicked
function showMoreNotices() {
    const hiddenNotices = document.querySelectorAll('.notice-item.hidden');
    const noticesToShow = Math.min(3, hiddenNotices.length);
    
    for (let i = 0; i < noticesToShow; i++) {
        hiddenNotices[i].classList.remove('hidden');
    }
    
    // Hide button if no more notices to show
    checkViewMoreButton();
}

// Check if "View More" button should be visible
function checkViewMoreButton() {
    const hiddenNotices = document.querySelectorAll('.notice-item.hidden');
    const viewMoreBtn = document.querySelector('.view-more-btn');
    
    if (hiddenNotices.length === 0) {
        viewMoreBtn.style.display = 'none';
    } else {
        viewMoreBtn.style.display = 'block';
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    checkViewMoreButton();
});

// Add this function to your existing JavaScript
function goBack() {
    window.history.back();
}       




// admindashboard js\

function enableEditing() {
    // Show all time inputs
    const timeInputs = document.querySelectorAll('.time-input');
    timeInputs.forEach(input => {
        input.style.display = 'inline-block';
    });
    
    // Hide all time displays
    const timeDisplays = document.querySelectorAll('.time-display');
    timeDisplays.forEach(display => {
        display.style.display = 'none';
    });
    
    // Toggle buttons
    document.querySelector('.edit-btn').style.display = 'none';
    document.querySelector('.update-btn').style.display = 'inline-block';
    document.querySelector('.cancel-btn').style.display = 'inline-block';
}

function cancelEditing() {
    // Hide all time inputs
    const timeInputs = document.querySelectorAll('.time-input');
    timeInputs.forEach(input => {
        input.style.display = 'none';
    });
    
    // Show all time displays
    const timeDisplays = document.querySelectorAll('.time-display');
    timeDisplays.forEach(display => {
        display.style.display = 'inline';
    });
    
    // Toggle buttons
    document.querySelector('.edit-btn').style.display = 'inline-block';
    document.querySelector('.update-btn').style.display = 'none';
    document.querySelector('.cancel-btn').style.display = 'none';
}

function updateTimes() {
    // Get all time inputs
    const timeInputs = document.querySelectorAll('.time-input');
    
    // Update the display values
    timeInputs.forEach(input => {
        const timeValue = input.value;
        const hours = parseInt(timeValue.split(':')[0]);
        const minutes = timeValue.split(':')[1];
        
        let displayTime = '';
        let period = 'AM';
        let displayHours = hours;
        
        if (hours >= 12) {
            period = 'PM';
            if (hours > 12) {
                displayHours = hours - 12;
            }
        }
        
        if (hours === 0) {
            displayHours = 12; // Midnight
        }
        
        displayTime = `${displayHours}:${minutes} ${period}`;
        
        // Find the corresponding display span
        const parentDiv = input.parentElement;
        const displaySpan = parentDiv.querySelector('.time-display');
        displaySpan.textContent = displayTime;
    });
    
    // Hide inputs and show displays
    cancelEditing();
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Set initial values for the time inputs based on the display text
    const timeDisplays = document.querySelectorAll('.time-display');
    
    timeDisplays.forEach(display => {
        const text = display.textContent.trim();
        const timePart = text.split(' ')[0]; // "8:00"
        const period = text.split(' ')[1]; // "AM"
        
        let [hours, minutes] = timePart.split(':');
        hours = parseInt(hours);
        
        if (period === 'PM' && hours < 12) {
            hours += 12;
        } else if (period === 'AM' && hours === 12) {
            hours = 0;
        }
        
        // Format hours to two digits
        const formattedHours = hours.toString().padStart(2, '0');
        
        // Find the corresponding input
        const parentDiv = display.parentElement;
        const input = parentDiv.querySelector('.time-input');
        input.value = `${formattedHours}:${minutes}`;
    });
});



function enableScheduleEdit() {
// Hide all time displays
const displays = document.querySelectorAll('#scheduleTable .time-display');
displays.forEach(display => {
    display.style.display = 'none';
});

// Show all time edit inputs
const inputs = document.querySelectorAll('#scheduleTable .time-edit');
inputs.forEach(input => {
    input.style.display = 'inline-block';
});

// Toggle buttons
document.querySelector('.edit-btn').style.display = 'none';
document.querySelector('.update-btn').style.display = 'inline-block';
document.querySelector('.cancel-btn').style.display = 'inline-block';
}

function cancelScheduleEdit() {
// Show all time displays
const displays = document.querySelectorAll('#scheduleTable .time-display');
displays.forEach(display => {
    display.style.display = 'inline';
});

// Hide all time edit inputs
const inputs = document.querySelectorAll('#scheduleTable .time-edit');
inputs.forEach(input => {
    input.style.display = 'none';
});

// Toggle buttons
document.querySelector('.edit-btn').style.display = 'inline-block';
document.querySelector('.update-btn').style.display = 'none';
document.querySelector('.cancel-btn').style.display = 'none';
}

function updateSchedule() {
// Update all time displays with edited values
const inputs = document.querySelectorAll('#scheduleTable .time-edit');
inputs.forEach(input => {
    const timeValue = input.value;
    const hours = parseInt(timeValue.split(':')[0]);
    const minutes = timeValue.split(':')[1];
    
    let displayTime = '';
    let period = 'AM';
    let displayHours = hours;
    
    if (hours >= 12) {
        period = 'PM';
        if (hours > 12) {
            displayHours = hours - 12;
        }
    }
    
    if (hours === 0) {
        displayHours = 12; // Midnight
    }
    
    displayTime = `${displayHours}:${minutes} ${period}`;
    
    // Find the corresponding display span
    const displaySpan = input.previousElementSibling;
    displaySpan.textContent = displayTime;
});

// Return to view mode
cancelScheduleEdit();

// Here you would typically send the updated data to your server
// saveScheduleToServer();
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
// Set initial values for the time inputs based on the display text
const displays = document.querySelectorAll('#scheduleTable .time-display');

displays.forEach(display => {
    const text = display.textContent.trim();
    const timePart = text.split(' ')[0]; // "8:00"
    const period = text.split(' ')[1]; // "AM"
    
    let [hours, minutes] = timePart.split(':');
    hours = parseInt(hours);
    
    if (period === 'PM' && hours < 12) {
        hours += 12;
    } else if (period === 'AM' && hours === 12) {
        hours = 0;
    }
    
    // Format hours to two digits
    const formattedHours = hours.toString().padStart(2, '0');
    
    // Find the corresponding input
    const input = display.nextElementSibling;
    input.value = `${formattedHours}:${minutes}`;
});
});



    // Format numbers with commas
    function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Toggle date picker visibility
function toggleDatePicker(type) {
    const picker = document.getElementById(`${type}DatePicker`);
    const allPickers = document.querySelectorAll('.date-picker');
    
    // Hide all other pickers
    allPickers.forEach(p => {
        if (p !== picker) {
            p.style.display = 'none';
        }
    });
    
    // Toggle current picker
    picker.style.display = picker.style.display === 'block' ? 'none' : 'block';
}

// Apply date filter (simulated)
function applyDateFilter(type) {
    const dateInput = document.getElementById(`${type}DateInput`);
    const selectedDate = dateInput.value;
    
    if (!selectedDate) {
        alert('Please select a date');
        return;
    }
    
    // In a real app, you would fetch data filtered by this date
    // For demo purposes, we'll just show the selected date
    alert(`Filtering ${type.replace('passengers', 'Passengers').replace('income', 'Income')} data for: ${selectedDate}`);
    
    // Hide the date picker
    document.getElementById(`${type}DatePicker`).style.display = 'none';
    
    // Here you would typically:
    // 1. Make an API call to get filtered data
    // 2. Update the statistics with the filtered data
    // 3. Maybe show a loading indicator while fetching
}

// Close date pickers when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.date-picker') && !event.target.closest('.sort-btn')) {
        document.querySelectorAll('.date-picker').forEach(picker => {
            picker.style.display = 'none';
        });
    }
});

// Initialize the stats when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Set today's date as default in the date pickers
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('passengersDateInput').value = today;
    document.getElementById('incomeDateInput').value = today;
});


document.getElementById('signout-link').addEventListener('click', function(e) {
    e.preventDefault();
    alert('You are going to signed out frpm the admin pannel');
    window.location.href = 'index.html';
});




// admin update notice.js



    // Edit a notice
    function editNotice(id) {
        const notice = notices.find(n => n.id === id);
        if (!notice) return;
        
        const row = document.querySelector(`tr[data-id="${id}"]`);
        row.innerHTML = `
            <td><input type="text" value="${notice.date}" id="editDate_${id}"></td>
            <td><input type="text" value="${notice.title}" id="editTitle_${id}"></td>
            <td>
                <select id="editCategory_${id}">
                    <option value="schedule" ${notice.category === 'schedule' ? 'selected' : ''}>Schedule Change</option>
                    <option value="maintenance" ${notice.category === 'maintenance' ? 'selected' : ''}>Maintenance</option>
                    <option value="safety" ${notice.category === 'safety' ? 'selected' : ''}>Safety Notice</option>
                    <option value="general" ${notice.category === 'general' ? 'selected' : ''}>General Announcement</option>
                    <option value="lost" ${notice.category === 'lost' ? 'selected' : ''}>Lost & Found</option>
                </select>
            </td>
            <td><textarea id="editContent_${id}">${notice.content}</textarea></td>
            <td class="action-buttons">
                <button class="btn-save" onclick="saveNotice(${id})"><i class="fas fa-save"></i> Save</button>
                <button class="btn-cancel" onclick="renderNoticeTable(notices)"><i class="fas fa-times"></i> Cancel</button>
            </td>
        `;
    }

    // Save edited notice
    function saveNotice(id) {
        const notice = notices.find(n => n.id === id);
        if (!notice) return;
        
        notice.date = document.getElementById(`editDate_${id}`).value;
        notice.title = document.getElementById(`editTitle_${id}`).value;
        notice.category = document.getElementById(`editCategory_${id}`).value;
        notice.content = document.getElementById(`editContent_${id}`).value;
        
        renderNoticeTable(notices);
        alert('Notice updated successfully!');
    }

    // Delete a notice
    function deleteNotice(id) {
        if (confirm('Are you sure you want to delete this notice?')) {
            const index = notices.findIndex(n => n.id === id);
            if (index !== -1) {
                notices.splice(index, 1);
                renderNoticeTable(notices);
                alert('Notice deleted successfully!');
            }
        }
    }

    // Filter notices by category
    function filterNotices(category) {
        // Update active tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        if (category === 'all') {
            renderNoticeTable(notices);
        } else {
            const filteredNotices = notices.filter(notice => notice.category === category);
            renderNoticeTable(filteredNotices);
        }
    }

    // Helper function to get category name
    function getCategoryName(category) {
        const names = {
            'schedule': 'Schedule Change',
            'maintenance': 'Maintenance',
            'safety': 'Safety Notice',
            'general': 'General Announcement',
            'lost': 'Lost & Found'
        };
        return names[category] || category;
    }