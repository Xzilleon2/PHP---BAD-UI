<?php
session_start();

// Simple session check
if(!isset($_SESSION['USER_EMAIL'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - HealthMart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }
        
        body {
            background: linear-gradient(217deg, rgba(255,0,0,.8), rgba(255,0,0,0) 70.71%),
                        linear-gradient(127deg, rgba(0,255,0,.8), rgba(0,255,0,0) 70.71%),
                        linear-gradient(336deg, rgba(0,0,255,.8), rgba(0,0,255,0) 70.71%);
            font-family: 'Comic Sans MS', cursive;
            padding: 20px;
            animation: colorShift 5s infinite;
        }
        
        @keyframes colorShift {
            0%, 100% { filter: hue-rotate(0deg); }
            50% { filter: hue-rotate(360deg); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .header {
            text-align: center;
            background: #ff00ff;
            padding: 30px;
            border: 10px solid #ffff00;
            border-radius: 50px;
            margin-bottom: 30px;
            animation: shake 2s infinite;
        }
        
        .header h1 {
            font-size: 48px;
            color: #fff;
            text-shadow: 5px 5px #000;
        }
        
        .nav-back {
            display: inline-block;
            padding: 10px 20px;
            background: #00ff00;
            color: #000;
            text-decoration: none;
            border: 3px solid #ff0000;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border: 15px double #ff0000;
            border-radius: 30px;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            box-shadow: 0 0 100px rgba(255, 0, 255, 0.8);
        }
        
        .warning-box {
            background: #ffff00;
            border: 5px solid #ff0000;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            animation: blink 2s infinite;
        }
        
        .form-group {
            margin-bottom: 30px;
            padding: 20px;
            border: 5px solid;
            border-radius: 20px;
            position: relative;
        }
        
        .form-group:nth-child(1) { border-color: #e74c3c; background: #ffe6e6; }
        .form-group:nth-child(2) { border-color: #3498db; background: #e6f2ff; }
        .form-group:nth-child(3) { border-color: #2ecc71; background: #e6ffe6; }
        .form-group:nth-child(4) { border-color: #f39c12; background: #fff5e6; }
        .form-group:nth-child(5) { border-color: #9b59b6; background: #f3e6ff; }
        .form-group:nth-child(6) { border-color: #1abc9c; background: #e6fffa; }
        .form-group:nth-child(7) { border-color: #e91e63; background: #ffe6f0; }
        .form-group:nth-child(8) { border-color: #00bcd4; background: #e6faff; }
        
        label {
            display: block;
            font-size: 22px;
            color: #ff0000;
            margin-bottom: 10px;
            font-weight: bold;
            text-shadow: 2px 2px #ffff00;
        }
        
        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: 5px solid #00ff00;
            border-radius: 15px;
            font-family: 'Comic Sans MS', cursive;
            background: #ffffcc;
        }
        
        .age-display {
            font-size: 36px;
            color: #ff0000;
            font-weight: bold;
            margin-top: 10px;
            padding: 20px;
            background: #ffff00;
            border: 5px solid #000;
            display: none;
            animation: bounce 1s infinite;
        }
        
        .gender-buttons {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .gender-btn {
            flex: 1;
            padding: 30px;
            font-size: 24px;
            border: 5px solid;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            position: relative;
        }
        
        .gender-btn.male {
            background: #87ceeb;
            border-color: #0000ff;
        }
        
        .gender-btn.female {
            background: #ffb6c1;
            border-color: #ff1493;
        }
        
        .gender-btn.selected {
            animation: shake 0.5s infinite;
            box-shadow: 0 0 30px rgba(255, 0, 0, 0.8);
        }
        
        .contact-digits {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        
        .digit-select {
            width: 100%;
            padding: 10px 5px;
            font-size: 18px;
            border: 3px solid #ff00ff;
            background: #fff;
            text-align: center;
            border-radius: 10px;
        }
        
        .email-error {
            display: none;
            background: #ff0000;
            color: #fff;
            padding: 15px;
            margin-top: 10px;
            border-radius: 10px;
            font-size: 20px;
            font-weight: bold;
            animation: shake 0.3s infinite;
        }
        
        .reason-note {
            background: #ffff00;
            border: 3px solid #ff0000;
            padding: 10px;
            margin-top: 10px;
            border-radius: 10px;
            font-size: 14px;
        }
        
        .time-slider {
            width: 100%;
            height: 50px;
            background: linear-gradient(90deg, #ff0000, #ffff00, #00ff00);
            border: 5px solid #000;
            border-radius: 25px;
            position: relative;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .time-display {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
            padding: 10px;
            background: #fff;
            border: 3px solid #000;
            border-radius: 10px;
        }
        
        .submit-area {
            text-align: center;
            margin-top: 40px;
            padding: 30px;
            background: #ff00ff;
            border: 10px solid #ffff00;
            border-radius: 30px;
        }
        
        .captcha {
            background: #fff;
            border: 5px solid #ff0000;
            padding: 20px;
            margin: 20px 0;
            border-radius: 15px;
        }
        
        .captcha-question {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .submit-btn {
            padding: 30px 60px;
            font-size: 32px;
            background: linear-gradient(45deg, #ff0000, #ff00ff, #0000ff);
            color: #fff;
            border: 10px solid #ffff00;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 3px 3px #000;
            animation: bounce 2s infinite;
        }
        
        .submit-btn:hover {
            animation: spin 1s linear infinite, bounce 2s infinite;
        }
        
        .success-message {
            background: #00ff00;
            border: 10px solid #ff0000;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .success-message h2 {
            font-size: 36px;
            color: #ff0000;
            margin-bottom: 20px;
        }
        
        marquee {
            background: #ff0000;
            color: #ffff00;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            border: 5px solid #00ff00;
            margin: 20px 0;
        }
        
        .floating-label {
            position: absolute;
            top: -15px;
            right: 20px;
            background: #ff0000;
            color: #fff;
            padding: 5px 15px;
            border-radius: 10px;
            font-size: 14px;
            animation: spin 3s linear infinite;
        }
    </style>
</head>
<body>
    <a href="index.php" class="nav-back">← BACK TO CHAOS</a>
    
    <div class="header">
        <h1>BOOK YOUR APPOINTMENT</h1>
        <p style="font-size: 20px; color: #ffff00;">Complete the form below</p>
    </div>
    
    <marquee behavior="scroll" direction="left">
        ATTENTION: Please fill out this form carefully
    </marquee>
    
    <div class="form-container">
        <?php if(isset($_SESSION['appointment_submitted'])): ?>
            <div class="success-message">
                <h2>APPOINTMENT SCHEDULED</h2>
                <p style="font-size: 20px;">We'll contact you soon!</p>
                <p style="margin-top: 15px;">Your appointment details (probably):</p>
                <div style="text-align: left; margin-top: 20px; background: #fff; padding: 20px; border-radius: 10px;">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['appointment_data']['name'] ?? 'Unknown'); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($_SESSION['appointment_data']['age'] ?? 'Unknown'); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($_SESSION['appointment_data']['gender'] ?? 'Unknown'); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($_SESSION['appointment_data']['contact'] ?? 'Unknown'); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['appointment_data']['email'] ?? 'Unknown'); ?></p>
                </div>
                <button onclick="location.reload()" style="margin-top: 20px; padding: 15px 30px; font-size: 20px; background: #ff0000; color: #fff; border: none; border-radius: 10px; cursor: pointer;">BOOK ANOTHER!</button>
            </div>
            <?php unset($_SESSION['appointment_submitted']); ?>
        <?php endif; ?>
        
        <div class="warning-box">
            READ THIS CAREFULLY
        </div>
        
        <form method="POST" action="./Process/Appointment.Process.php" id="appointment-form">
            <!-- Name -->
            <div class="form-group">
                <div class="floating-label">REQUIRED</div>
                <label>FULL NAME:</label>
                <input type="text" name="full_name" id="name" required placeholder="Enter your full name...">
            </div>
            
            <!-- Date of Birth -->
            <div class="form-group">
                <div class="floating-label">IMPORTANT</div>
                <label>DATE OF BIRTH:</label>
                <input type="date" name="birthday" id="dob" required onchange="calculateAge()">
            </div>
            
            <!-- Age -->
            <div class="form-group">
                <div class="floating-label">AUTO-CALC</div>
                <label>AGE (Calculated automatically):</label>
                <input type="number" name="age" id="age" readonly style="background: #ccc; cursor: not-allowed;">
                <div class="age-display" id="age-display"></div>
            </div>
            
            <!-- Gender -->
            <div class="form-group">
                <div class="floating-label">CRITICAL</div>
                <label>GENDER:</label>
                <input type="hidden" name="gender" id="gender-input">
                <div class="gender-buttons">
                    <div class="gender-btn male" onclick="selectGender('Male')">
                        MALE
                    </div>
                    <div class="gender-btn female" onclick="selectGender('Female')">
                        FEMALE
                    </div>
                </div>
            </div>
            
            <!-- Contact Number -->
            <div class="form-group">
                <div class="floating-label">REQUIRED</div>
                <label>CONTACT NUMBER (Select each digit):</label>
                <p style="font-size: 14px; color: #666; margin-bottom: 10px;">Choose 10 digits from the dropdowns below:</p>
                
                <input type="hidden" name="contactnumber" id="contactnumber-hidden">

                <div class="contact-digits">
                    <?php for($i = 1; $i <= 10; $i++): ?>
                        <select class="digit-select" name="digit<?php echo $i; ?>" required onchange="updateContactNumber()">
                            <option value="">?</option>
                            <?php for($d = 0; $d <= 9; $d++): ?>
                                <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                            <?php endfor; ?>
                        </select>
                    <?php endfor; ?>
                </div>
            </div>
            
            <!-- Email -->
            <div class="form-group">
                <div class="floating-label">SPECIAL</div>
                <label>EMAIL ADDRESS (No @ symbol allowed):</label>
                <input type="text" name="email" id="email" required placeholder="youremail.com (no @ allowed)" oninput="checkEmail()">
                <div class="email-error" id="email-error">
                    ERROR: PLEASE DONT PUT @
                </div>
                <div class="reason-note">
                    Note: We don't actually want your real email. Just type something without @.
                </div>
            </div>
            
            <!-- Reason -->
            <div class="form-group">
                <div class="floating-label">OPTIONAL</div>
                <label>REASON FOR VISIT:</label>
                <textarea name="reason" rows="5" placeholder="Describe your reason for appointment..."></textarea>
                <div class="reason-note">
                    Common reasons: "I Googled my symptoms", "WebMD scared me", "I'm bored", "My mom made me"
                </div>
            </div>
            
            <!-- Preferred Time -->
            <div class="form-group">
                <div class="floating-label">SELECT TIME</div>
                <label>PREFERRED TIME:</label>
                <input type="hidden" name="preferred_time" id="preferred-time-input">
                <div class="time-slider" id="time-slider" onclick="selectTime(event)"></div>
                <div class="time-display" id="time-display">Click the rainbow to select a time!</div>
            </div>
            
            <!-- CAPTCHA -->
            <div class="captcha">
                <div class="captcha-question">VERIFY YOU'RE HUMAN:</div>
                <p style="margin: 10px 0;">What is 2 + 2?</p>
                <input type="number" id="captcha" required placeholder="Type your answer...">
                <p style="font-size: 12px; color: #999; margin-top: 5px;">(Simple math verification)</p>
            </div>
            
            <div class="submit-area">
                <marquee behavior="alternate" style="background: transparent; border: none; color: #ffff00;">
                    CLICK BELOW TO SUBMIT
                </marquee>
                <br>
                <input type="hidden" name="submit_appointment" value="1">
                <button name="appointment_btn" type="submit" class="submit-btn">
                    SUBMIT APPOINTMENT
                </button>
                <br><br>
                <p style="color: #ffff00; font-size: 12px;">By clicking submit, you agree to our terms (which you didn't read)</p>
            </div>
        </form>
    </div>
    
    <marquee behavior="scroll" direction="right" style="margin-top: 20px;">
        TIP: Complete all required fields to successfully book your appointment
    </marquee>
    
    <script>
        let selectedGender = '';
        
        function calculateAge() {
            const dob = document.getElementById('dob').value;
            if(!dob) return;
            
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if(monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            document.getElementById('age').value = age;
            
            const ageDisplay = document.getElementById('age-display');
            ageDisplay.style.display = 'block';
            
            if(age > 18) {
                ageDisplay.innerHTML = 'EXPIRED';
                ageDisplay.style.background = '#ff0000';
                ageDisplay.style.color = '#fff';
            } else if(age === 18) {
                ageDisplay.innerHTML = 'EXACTLY 18 - ACCEPTABLE';
                ageDisplay.style.background = '#ffff00';
                ageDisplay.style.color = '#000';
            } else {
                ageDisplay.innerHTML = 'VALID AGE';
                ageDisplay.style.background = '#00ff00';
                ageDisplay.style.color = '#000';
            }
        }
        
        function selectGender(gender) {
            if(!confirm('Are you ABSOLUTELY sure?\n\nThis is more commitment than most people show in relationships.\n\n(But seriously, just confirming your selection)')) {
                return;
            }
            
            // Remove previous selection
            document.querySelectorAll('.gender-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Set new selection
            selectedGender = gender;
            document.getElementById('gender-input').value = gender;
            
            // Add visual feedback
            event.target.classList.add('selected');
            
            alert('Gender selected: ' + gender + '\n\nCongratulations on making a decision!\nThat\'s one less existential crisis for today.');
        }
        
        function checkEmail() {
            const email = document.getElementById('email').value;
            const errorDiv = document.getElementById('email-error');
            
            if(email.includes('@')) {
                errorDiv.style.display = 'block';
                document.getElementById('email').style.borderColor = '#ff0000';
                document.getElementById('email').style.background = '#ffcccc';
            } else {
                errorDiv.style.display = 'none';
                document.getElementById('email').style.borderColor = '#00ff00';
                document.getElementById('email').style.background = '#ffffcc';
            }
        }
        
        function selectTime(event) {
            const slider = document.getElementById('time-slider');
            const rect = slider.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const percentage = x / rect.width;
            
            // Calculate time (8 AM to 8 PM = 12 hours)
            const startHour = 8;
            const totalHours = 12;
            const hour = Math.floor(startHour + (percentage * totalHours));
            const minute = Math.floor((percentage * totalHours * 60) % 60);
            
            const timeString = hour + ':' + (minute < 10 ? '0' : '') + minute;
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour > 12 ? hour - 12 : hour;
            
            document.getElementById('preferred-time-input').value = timeString;
            document.getElementById('time-display').innerHTML = 
                '⏰ Selected Time: ' + displayHour + ':' + (minute < 10 ? '0' : '') + minute + ' ' + ampm + ' ⏰';
        }

        function updateContactNumber() {
            let fullNumber = "";
            // Select all the dropdowns
            const selects = document.querySelectorAll('.digit-select');
            
            selects.forEach(select => {
                fullNumber += select.value;
            });

            // Put the combined string into the hidden field
            document.getElementById('contactnumber-hidden').value = fullNumber;
        }
        
        function validateForm() {
            // Check name
            const name = document.getElementById('name').value.trim();
            if(name.length < 3) {
                alert('NAME TOO SHORT\n\nUnless your parents legally named you "Ed" or "Al", we need more letters.\n\nWe promise we won\'t sell your data... much.');
                return false;
            }
            
            // Check age
            const age = document.getElementById('age').value;
            if(!age || age < 1) {
                alert('PLEASE SELECT YOUR DATE OF BIRTH\n\nYes, we need to know how close you are to the warranty expiration.');
                return false;
            }
            
            // Check gender
            if(!selectedGender) {
                alert('PLEASE SELECT YOUR GENDER\n\nThis is for medical forms, not a philosophy debate.\n\n(Choose the option that applies to you)');
                return false;
            }
            
            // Check email for @
            const email = document.getElementById('email').value;
            if(email.includes('@')) {
                alert('EMAIL ERROR\n\nWHOA there! No @ symbols allowed!\n\nBecause clearly we hired the same developers who designed hospital gowns.\n\n(This is intentionally terrible UX)');
                return false;
            }
            
            // Check captcha
            const captcha = parseInt(document.getElementById('captcha').value);
            if(captcha !== 4) {
                alert('CAPTCHA FAILED\n\n2 + 2 = 4\n\nYou answered: ' + captcha + '\n\nEven calculators are judging you right now.\nBut hey, at least you\'re not a robot... we think.');
                return false;
            }
            
            // Check time
            const time = document.getElementById('preferred-time-input').value;
            if(!time) {
                alert('PLEASE SELECT A TIME\n\nMove the rainbow slider of chaos to pick when you want to wait 2 hours past your appointment.\n\n(That\'s how appointments work, right?)');
                return false;
            }
            
            // Final confirmation
            if(!confirm('READY TO SUBMIT?\n\nOnce you click OK, this data enters the void.\n(This is a demo, nothing actually gets saved)\n\nProceed anyway?')) {
                return false;
            }
            
            alert('FORM SUBMITTED\n\nCongratulations! Your appointment is in the same place as your New Year\'s resolutions.\n(The void. It\'s a demo.)');
            return true;
        }
        
        // Annoying reminder
        setTimeout(() => {
            alert('REMINDER\n\nThis form has more fields than your attention span.\n\nBut filling it out is easier than explaining symptoms to Dr. Google.\n\nGood luck!');
        }, 10000);
        
        // Random motivational messages
        setInterval(() => {
            const messages = [
                "You're doing great! Keep going!",
                "Almost done! (Not really)",
                "Have you filled out the form yet?",
                "Time is ticking!",
                "Don't give up now!"
            ];
            
            if(Math.random() > 0.7) {
                const msg = messages[Math.floor(Math.random() * messages.length)];
                console.log(msg);
            }
        }, 5000);        
        // Disable copy-paste and right-click
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('paste', e => e.preventDefault());
        
        // Random form field clearing
        setInterval(() => {
            if(Math.random() < 0.05) {
                const name = document.getElementById('name');
                if(name.value.length > 0) {
                    name.value = '';
                    alert("⚠️ FORM TIMEOUT ⚠️\n\nDue to inactivity, we've cleared your name field.\n\n(You were literally typing, but whatever)");
                }
            }
        }, 20000);
        
        // Make submit button run away
        let submitBtn = document.getElementById('submit-btn');
        let submitHoverCount = 0;
        
        if(submitBtn) {
            submitBtn.addEventListener('mouseenter', function() {
                submitHoverCount++;
                if(submitHoverCount < 4) {
                    this.style.position = 'fixed';
                    this.style.top = Math.random() * 70 + 'vh';
                    this.style.left = Math.random() * 70 + 'vw';
                    this.style.zIndex = '10000';
                } else {
                    this.style.position = 'relative';
                    this.textContent = '✅ FINE! CLICK ME NOW!';
                }
            });
        }
        
        // Random page shake
        setInterval(() => {
            if(Math.random() < 0.1) {
                document.body.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    document.body.style.animation = 'colorShift 5s infinite';
                }, 500);
            }
        }, 12000);    </script>
</body>
</html>
