<?php
session_start();

// Randomly fail login 30% of the time just to frustrate users
$randomFail = (rand(1, 10) <= 3);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMart Login - Professional Healthcare Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
        }
        
        body {
            background: linear-gradient(45deg, #ff00ff, #00ffff, #ffff00, #ff00ff);
            background-size: 400% 400%;
            animation: gradientShift 3s ease infinite;
            font-family: 'Comic Sans MS', cursive;
            overflow-x: hidden;
            position: relative;
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"><circle cx="10" cy="10" r="8" fill="red"/></svg>'), auto;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            10% { transform: translateX(-10px) rotate(-2deg); }
            20% { transform: translateX(10px) rotate(2deg); }
            30% { transform: translateX(-10px) rotate(-2deg); }
            40% { transform: translateX(10px) rotate(2deg); }
            50% { transform: translateX(-10px) rotate(-2deg); }
            60% { transform: translateX(10px) rotate(2deg); }
            70% { transform: translateX(-10px) rotate(-2deg); }
            80% { transform: translateX(10px) rotate(2deg); }
            90% { transform: translateX(-10px) rotate(-2deg); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .container {
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 48px;
            color: #ff0000;
            text-shadow: 3px 3px #00ff00, 6px 6px #0000ff;
            animation: shake 0.5s infinite;
        }
        
        .blinking-text {
            font-size: 24px;
            color: #ff00ff;
            animation: blink 1s infinite;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            border: 10px solid #ff6600;
            border-radius: 50px;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 0 50px rgba(255, 0, 255, 0.8);
            position: relative;
            animation: spin 20s linear infinite;
        }
        
        .warning-banner {
            background: yellow;
            border: 5px solid red;
            padding: 10px;
            margin-bottom: 20px;
            animation: blink 1.5s infinite;
            font-weight: bold;
            text-align: center;
        }
        
        .error-message {
            background: #ff0000;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border: 3px solid #000;
            font-weight: bold;
            animation: shake 0.5s infinite;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-size: 18px;
            color: #ff0000;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"], input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 3px solid #00ff00;
            border-radius: 10px;
            font-size: 16px;
            background: #ffffcc;
        }
        
        .small-login-btn {
            padding: 3px 8px;
            font-size: 10px;
            background: #cccccc;
            border: 1px solid #999999;
            color: #666666;
            cursor: pointer;
            border-radius: 3px;
            position: absolute;
            right: 40px;
            transition: all 0.2s;
        }
        
        .small-login-btn:hover {
            transform: translate(50px, -30px);
        }
        
        .small-signup-link {
            font-size: 8px;
            color: #999999;
            text-decoration: underline;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
        }
        
        .giant-forgot-btn {
            width: 100%;
            padding: 40px;
            font-size: 32px;
            background: linear-gradient(45deg, #ff0000, #ff00ff, #0000ff);
            color: white;
            border: 10px solid #ffff00;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 30px;
            animation: float 2s infinite;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            text-shadow: 3px 3px #000000;
        }
        
        .giant-forgot-btn:hover {
            animation: shake 0.3s infinite;
        }
        
        .random-popup {
            position: fixed;
            background: #ff00ff;
            border: 5px solid #ffff00;
            padding: 20px;
            border-radius: 10px;
            z-index: 1000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.8);
        }
        
        .floating-text {
            position: fixed;
            animation: float 3s infinite;
            font-size: 24px;
            font-weight: bold;
            color: #ff0000;
            text-shadow: 2px 2px #00ff00;
        }
        
        #signup-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border: 10px solid #ff0000;
            padding: 30px;
            z-index: 2000;
            border-radius: 20px;
        }
        
        .modal-close {
            background: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 15px;
        }
        
        marquee {
            background: #ff0000;
            color: #ffff00;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            border: 3px solid #00ff00;
        }
    </style>
</head>
<body>
    <marquee behavior="scroll" direction="left">WELCOME TO HEALTHMART - Professional Healthcare Services | Limited Time Offers Available</marquee>
    
    <div class="container">
        <div class="header">
            <h1>HEALTHMART</h1>
            <div class="blinking-text">WELCOME FUTURE PAIIENT</div>
            <div class="blinking-text" style="animation-delay: 0.5s;">LOGIN NOW</div>
        </div>
        
        <div class="login-container" id="login-box">
            <div class="warning-banner">
                ⚠️ WARNING: LOGGING IN REQUIRED OR ELSE ⚠️
            </div>
            
            <?php if(isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="./Process/Signin.Process.php">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="signin_email" id="username" placeholder="Enter your email..." required autocomplete="off" onpaste="return false;" oncopy="return false;">
                </div>
                
                <div class="form-group">
                    <label>PASSWORD:</label>
                    <input type="password" name="signin_password" id="password" placeholder="Enter password..." required autocomplete="off" onpaste="return false;" oncopy="return false;">
                </div>
                
                <div class="form-group">
                    <label>CONFIRM YOU'RE NOT A ROBOT (Type "I am not a robot" exactly):</label>
                    <input type="text" name="captcha" id="captcha" required autocomplete="off">
                </div>
                
                <button name="signin_btn" type="submit" class="small-login-btn" id="login-btn" title="Try to click me!">login</button>
                <br><br><br>
                <a class="small-signup-link" onclick="showSignup()" style="opacity: 0.3;">sign up (click here if you can see this)</a>
            </form>
            
            <button class="giant-forgot-btn" onclick="forgotPassword()">
                ★★★ I FORGOT MY PASSWORD ★★★<br>
                (CLICK THIS HUGE BUTTON)
            </button>
        </div>
        
        <!-- Floating random texts -->
        <div class="floating-text" style="top: 10%; left: 10%;">HEALTH!</div>
        <div class="floating-text" style="top: 20%; right: 15%; animation-delay: 0.5s;">WELLNESS!</div>
        <div class="floating-text" style="bottom: 15%; left: 20%; animation-delay: 1s;">VITAMINS!</div>
        <div class="floating-text" style="bottom: 10%; right: 10%; animation-delay: 1.5s;">CHAOS!</div>
    </div>
    
    <!-- Signup Modal -->
    <div id="signup-modal">
        <h2 style="color: #ff0000;">CREATE ACCOUNT (QUESTIONABLE DECISION)</h2>
        <form method="POST" action="./Process/Signup.Process.php">
            <input type="hidden" name="action" value="signup">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="signup_name" required>
            </div>
            <div class="form-group">
                <label>Email (we'll spam you):</label>
                <input type="text" name="signup_email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="signup_password" required>
            </div>
            <button name="signup_btn" type="submit" style="background: #00ff00; padding: 10px 20px; border: none; font-size: 16px; cursor: pointer;">SIGN UP NOW!!!</button>
            <button type="button" class="modal-close" onclick="closeSignup()">Close</button>
        </form>
    </div>
    
    <marquee behavior="scroll" direction="right" style="position: fixed; bottom: 0; width: 100%;">
        HOT DEALS: Special Offers Available | Check our products today
    </marquee>
    
    <script>
        // Disable right-click
        document.addEventListener('contextmenu', e => e.preventDefault());
        
        // Disable copy-paste (already in HTML but extra layer)
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('paste', e => e.preventDefault());
        
        // Random pop-ups
        function createRandomPopup() {
            const messages = [
                "🔥 SPECIAL OFFER! 50% OFF!",
                "💊 HEALTH PRODUCTS ON SALE!",
                "⚡ LIMITED TIME ONLY!",
                "🎉 NEW ARRIVALS!",
                "👆 CLICK HERE FOR DEALS!",
                "⭐ TRENDING NOW!",
                "🚀 SUBSCRIBE TO NEWSLETTER!"
            ];
            
            const popup = document.createElement('div');
            popup.className = 'random-popup';
            popup.style.top = Math.random() * 70 + 10 + 'vh';
            popup.style.left = Math.random() * 70 + 10 + 'vw';
            popup.innerHTML = messages[Math.floor(Math.random() * messages.length)];
            popup.onclick = function() { 
                alert("Thanks for clicking! But there's no actual deal. 😄");
                this.remove(); 
            };
            
            document.body.appendChild(popup);
            
            setTimeout(() => popup.remove(), 4000);
        }
        
        setInterval(createRandomPopup, 3000);
        
        // Make login button run away
        let loginBtn = document.getElementById('login-btn');
        let escapeCount = 0;
        
        loginBtn.addEventListener('mouseenter', function() {
            escapeCount++;
            if(escapeCount < 5) {
                this.style.position = 'fixed';
                this.style.top = Math.random() * 80 + 'vh';
                this.style.left = Math.random() * 80 + 'vw';
            } else {
                this.style.position = 'relative';
                this.style.top = 'auto';
                this.style.left = 'auto';
                this.textContent = 'FINE, CLICK ME';
                this.style.fontSize = '16px';
                this.style.padding = '10px 20px';
                this.style.background = '#00ff00';
            }
        });
        
        // Random alerts
        setTimeout(() => {
            alert("⚠️ WELCOME TO HEALTHMART ⚠️\n\nImportant Notice:\n\nBy using this website, you agree to receive 47 emails per day about health tips you didn't ask for.\n\nClick OK to continue...");
        }, 1500);
        
        setTimeout(() => {
            if(confirm("🎉 SPECIAL PROMOTION! 🎉\n\nWould you like to hear about our extended warranty for your health?\n\n(Clicking either button does nothing)")) {
                alert("Great! We'll spam your inbox starting now! 📧");
            } else {
                alert("Too bad! We'll spam you anyway! 📧");
            }
        }, 5000);
        
        // Randomly clear form fields
        setInterval(() => {
            if(Math.random() < 0.1) {
                document.getElementById('username').value = '';
                document.getElementById('password').value = '';
                alert("⚠️ SESSION TIMEOUT ⚠️\n\nFor your security, we've cleared your login form.\n\n(It's been like 10 seconds but whatever)");
            }
        }, 15000);
        
        // Validation function
        function validateLogin() {
            const captcha = document.getElementById('captcha').value;
            if(captcha !== "I am not a robot") {
                alert("❌ CAPTCHA FAILED!\n\nYou must type EXACTLY: 'I am not a robot'\n\nCase sensitive. No extra spaces. No mistakes.\n\nTry again!");
                return false;
            }
            
            // Random fake errors
            if(Math.random() < 0.3) {
                alert("⚠️ SYSTEM ERROR ⚠️\n\nError Code: " + Math.floor(Math.random() * 9000 + 1000) + "\n\nPlease try again in a few moments.\n\n(Translation: Just click login again)");
                return false;
            }
            
            // Fake loading screen
            const loadingDiv = document.createElement('div');
            loadingDiv.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);z-index:9999;display:flex;align-items:center;justify-content:center;flex-direction:column;color:white;font-size:24px;';
            loadingDiv.innerHTML = '<div style="animation: spin 2s linear infinite;">⏳</div><br>PROCESSING YOUR LOGIN...<br><br>This may take several seconds...<br><br>(Actually it\'s instant but we want you to wait)';
            document.body.appendChild(loadingDiv);
            
            setTimeout(() => {
                loadingDiv.remove();
            }, 3000);
            
            setTimeout(() => {
                document.getElementById('login-form').submit();
            }, 3100);
            
            return false; // Prevent immediate submission
        }
        
        function forgotPassword() {
            alert("🔐 PASSWORD RECOVERY 🔐\n\nStep 1: Try to remember it\nStep 2: Try your birthday\nStep 3: Try 'password123'\nStep 4: Give up\n\n(For demo purposes, any password works)");
            alert("📧 Email Sent!\n\nWe've sent a password reset link to an email address we don't actually have.\n\nPlease check your spam folder, your trash, and possibly your neighbor's mailbox.");
            alert("⚠️ SECURITY NOTICE ⚠️\n\nFor your protection, we've:\n- Locked your account\n- Notified the FBI\n- Called your mom\n- Ordered you a pizza\n\nJust kidding. Just use any password for this demo.");
        }
        
        function showSignup() {
            if(confirm("⚠️ Are you ABSOLUTELY SURE you want to sign up?\n\nThis is a very serious decision that will haunt you forever.")) {
                if(confirm("⚠️ Are you REALLY REALLY sure?\n\nLike, 100% sure?")) {
                    if(confirm("⚠️ Last chance to back out...\n\nNo? Okay then...")) {
                        document.getElementById('signup-modal').style.display = 'block';
                    }
                }
            }
        }
        
        function closeSignup() {
            if(confirm("Are you sure you want to close this? You'll have to go through all those confirmations again!")) {
                document.getElementById('signup-modal').style.display = 'none';
            }
        }
        
        // Shake the whole page randomly
        setInterval(() => {
            if(Math.random() < 0.15) {
                document.body.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    document.body.style.animation = '';
                }, 500);
            }
        }, 8000);
        
        // Random cursor changes
        const cursors = ['wait', 'not-allowed', 'grab', 'grabbing', 'crosshair', 'move'];
        setInterval(() => {
            if(Math.random() < 0.2) {
                document.body.style.cursor = cursors[Math.floor(Math.random() * cursors.length)];
                setTimeout(() => {
                    document.body.style.cursor = 'default';
                }, 2000);
            }
        }, 7000);
        
        // Make login box spin occasionally
        setInterval(() => {
            const loginBox = document.getElementById('login-box');
            if(Math.random() < 0.1) {
                loginBox.style.animation = 'spin 2s linear 1';
                setTimeout(() => {
                    loginBox.style.animation = 'spin 20s linear infinite';
                }, 2000);
            }
        }, 10000);
    </script>
</body>
</html>
