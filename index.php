<?php
session_start();

// Simple session check
if(!isset($_SESSION['USER_EMAIL'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthMart - Healthcare Products & Services</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }
        
        body {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"><rect fill="%23ff00ff" width="50" height="50"/><rect fill="%2300ffff" x="50" width="50" height="50"/><rect fill="%23ffff00" y="50" width="50" height="50"/><rect fill="%2300ff00" x="50" y="50" width="50" height="50"/></svg>');
            font-family: 'Comic Sans MS', 'Papyrus', cursive;
            color: #000;
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"><text y="15" font-size="20">💊</text></svg>'), auto;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes slide {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .header {
            background: linear-gradient(90deg, red, orange, yellow, green, blue, indigo, violet);
            padding: 20px;
            text-align: center;
            border-bottom: 10px solid #000;
        }
        
        .header h1 {
            font-size: 60px;
            color: #fff;
            text-shadow: 5px 5px 10px #000;
            animation: shake 0.5s infinite;
        }
        
        .username-display {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff00ff;
            padding: 10px;
            border: 3px solid #ffff00;
            border-radius: 10px;
            font-size: 18px;
            animation: rotate 3s linear infinite;
        }
        
        .navigation {
            background: #ffff00;
            border: 5px dashed #ff0000;
            padding: 15px;
            text-align: center;
            overflow: hidden;
        }
        
        .nav-item {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            background: #00ff00;
            border: 5px solid #0000ff;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            color: #000;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .nav-item:hover {
            animation: bounce 0.5s infinite;
            transform: scale(1.2) rotate(360deg);
        }
        
        .nav-item:active {
            transform: translateY(100px);
        }
        
        .nav-item:nth-child(1) { background: #ff6b6b; }
        .nav-item:nth-child(2) { background: #4ecdc4; }
        .nav-item:nth-child(3) { background: #45b7d1; }
        .nav-item:nth-child(4) { background: #f7dc6f; }
        .nav-item:nth-child(5) { background: #bb8fce; }
        .nav-item:nth-child(6) { background: #85c1e2; }
        .nav-item:nth-child(7) { background: #f8b739; }
        
        .banner {
            background: #ff0000;
            color: #ffff00;
            padding: 20px;
            font-size: 30px;
            text-align: center;
            border: 8px solid #00ff00;
            margin: 20px;
            animation: blink 1s infinite;
        }
        
        .container {
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }
        
        .product-card {
            background: #fff;
            border: 8px solid;
            padding: 20px;
            text-align: center;
            border-radius: 30px;
            box-shadow: 10px 10px 20px rgba(0,0,0,0.5);
            position: relative;
        }
        
        .product-card:nth-child(1) { border-color: #e74c3c; transform: rotate(-2deg); }
        .product-card:nth-child(2) { border-color: #3498db; transform: rotate(2deg); }
        .product-card:nth-child(3) { border-color: #2ecc71; transform: rotate(-3deg); }
        .product-card:nth-child(4) { border-color: #f39c12; transform: rotate(3deg); }
        .product-card:nth-child(5) { border-color: #9b59b6; transform: rotate(-2deg); }
        .product-card:nth-child(6) { border-color: #1abc9c; transform: rotate(2deg); }
        
        .product-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ff0000;
        }
        
        .product-card .price {
            font-size: 36px;
            color: #00ff00;
            text-shadow: 2px 2px #000;
            margin: 10px 0;
        }
        
        .buy-btn {
            background: linear-gradient(45deg, #ff0000, #ff00ff);
            color: #fff;
            padding: 15px 30px;
            border: 5px solid #ffff00;
            font-size: 20px;
            cursor: pointer;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 5px 5px 10px rgba(0,0,0,0.5);
        }
        
        .buy-btn:hover {
            animation: shake 0.2s infinite;
        }
        
        .floating-icon {
            position: fixed;
            font-size: 50px;
            animation: bounce 2s infinite;
        }
        
        .sidebar {
            position: fixed;
            right: 0;
            top: 200px;
            background: #ff00ff;
            padding: 20px;
            border: 5px solid #ffff00;
            border-right: none;
            border-radius: 20px 0 0 20px;
        }
        
        .sidebar h3 {
            color: #ffff00;
            margin-bottom: 10px;
        }
        
        .wellness-tip {
            background: #fff;
            padding: 10px;
            margin: 10px 0;
            border: 3px solid #00ff00;
            border-radius: 10px;
            font-size: 14px;
        }
        
        marquee {
            font-size: 24px;
            font-weight: bold;
            padding: 10px;
        }
        
        .emergency-btn {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #ff0000;
            color: #fff;
            padding: 30px 60px;
            font-size: 40px;
            border: 10px solid #ffff00;
            border-radius: 50px;
            cursor: pointer;
            animation: blink 1.5s infinite;
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.8);
            z-index: 1000;
        }
        
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border: 10px solid #ff0000;
            padding: 30px;
            z-index: 2000;
            border-radius: 20px;
            max-width: 500px;
        }
        
        .popup-close {
            background: #ff0000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 15px;
        }
        
        .sticker {
            position: absolute;
            background: #ffff00;
            border: 3px solid #ff0000;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            transform: rotate(-15deg);
            box-shadow: 3px 3px 5px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="username-display">
        👤 <?php echo htmlspecialchars($username); ?>
    </div>
    
    <div class="header">
        <h1>HEALTHMART</h1>
        <p style="font-size: 24px; color: #ffff00;">Professional Healthcare Solutions</p>
    </div>
    
    <marquee behavior="scroll" direction="left" style="background: #00ff00; color: #ff0000;">
        FLASH SALE: 50% OFF Select Items | FREE SHIPPING ON ORDERS OVER $50 | BUY NOW
    </marquee>
    
    <div class="navigation">
        <a href="index.php" class="nav-item">SHOP</a>
        <a href="appointment.php" class="nav-item">APPOINTMENT</a>
        <a href="bmi.php" class="nav-item">BMI CALCULATOR</a>
        <a href="symptom-checker.php" class="nav-item">SYMPTOMS</a>
        <a href="am-i-dying.php" class="nav-item">HEALTH TRIAGE</a>
        <a href="first-aid.php" class="nav-item">FIRST AID</a>
        <a href="mental-health.php" class="nav-item">MENTAL HEALTH</a>
    </div>
    
    <div class="banner">
        LIMITED TIME OFFER: SPECIAL DISCOUNTS AVAILABLE
    </div>
    
    <div class="container">
        <div class="product-card">
            <div class="sticker" style="top: -10px; right: 10px;">NEW!</div>
            <h3>MEGA VITAMINS</h3>
            <p>Complete daily nutrition supplement</p>
            <div class="price">$99.99</div>
            <button class="buy-btn" onclick="buyProduct('Mega Vitamins')">BUY NOW</button>
        </div>
        
        <div class="product-card">
            <div class="sticker" style="top: -10px; left: 10px;">HOT!</div>
            <h3>SLEEP BOOSTER</h3>
            <p>Natural sleep aid supplement</p>
            <div class="price">$149.99</div>
            <button class="buy-btn" onclick="buyProduct('Sleep Booster')">ADD TO CART</button>
        </div>
        
        <div class="product-card">
            <div class="sticker" style="top: -10px; right: 10px;">SALE!</div>
            <h3>STRESS RELIEF KIT</h3>
            <p>Complete relaxation package</p>
            <div class="price">$199.99</div>
            <button class="buy-btn" onclick="buyProduct('Stress Relief Kit')">GET IT NOW</button>
        </div>
        
        <div class="product-card">
            <h3>MEDITATION APP</h3>
            <p>Guided meditation program</p>
            <div class="price">$79.99</div>
            <button class="buy-btn" onclick="buyProduct('Meditation App')">PURCHASE</button>
        </div>
        
        <div class="product-card">
            <div class="sticker" style="top: 10px; right: 10px;">POPULAR</div>
            <h3>ENERGY DRINK</h3>
            <p>Natural energy boost formula</p>
            <div class="price">$29.99</div>
            <button class="buy-btn" onclick="buyProduct('Energy Drink')">BUY NOW</button>
        </div>
        
        <div class="product-card">
            <h3>HERBAL REMEDY</h3>
            <p>Traditional herbal supplement</p>
            <div class="price">$299.99</div>
            <button class="buy-btn" onclick="buyProduct('Herbal Remedy')">ORDER NOW</button>
        </div>
    </div>
    
    <!-- Floating Icons -->
    <div class="floating-icon" style="top: 150px; left: 20px;">💊</div>
    <div class="floating-icon" style="top: 300px; right: 50px; animation-delay: 0.5s;">💉</div>
    <div class="floating-icon" style="bottom: 200px; left: 100px; animation-delay: 1s;">🏥</div>
    
    <!-- Sidebar Mental Health Corner -->
    <div class="sidebar">
        <h3>Wellness Tips</h3>
        <div class="wellness-tip">Remember to stay hydrated</div>
        <div class="wellness-tip">Maintain a balanced diet</div>
        <div class="wellness-tip">Practice positive thinking</div>
        <div class="wellness-tip">Get adequate sleep</div>
    </div>
    
    <!-- Emergency Button -->
    <button class="emergency-btn" onclick="showEmergency()">
        HEALTH ASSESSMENT
    </button>
    
    <!-- Pop-up -->
    <div id="emergency-popup" class="popup">
        <h2 style="color: #ff0000;">HEALTH ASSESSMENT</h2>
        <p style="font-size: 18px; margin: 20px 0;">
            Quick Self-Check:<br><br>
            ✅ Can you read this message? Generally positive sign.<br>
            ✅ Are you breathing normally? Good indicator.<br>
            ✅ Can you interact with this screen? Functioning well.<br><br>
            <strong>Disclaimer: This is not medical advice. For actual health concerns, please consult a healthcare professional.</strong>
        </p>
        <button class="popup-close" onclick="closeEmergency()">CLOSE</button>
    </div>
    
    <marquee behavior="scroll" direction="right" style="background: #0000ff; color: #ffff00; position: fixed; bottom: 0; width: 100%;">
        SPECIAL DISCOUNT CODE: "HEALTH2026" FOR 10% OFF | SUBSCRIBE TO OUR NEWSLETTER
    </marquee>
    
    <script>
        // Disable right-click
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('paste', e => e.preventDefault());
        
        // Make buttons run away sometimes
        document.querySelectorAll('.buy-btn').forEach((btn, index) => {
            let hoverCount = 0;
            btn.addEventListener('mouseenter', function() {
                hoverCount++;
                if(hoverCount <= 3) {
                    this.style.position = 'fixed';
                    this.style.top = Math.random() * 70 + 10 + 'vh';
                    this.style.left = Math.random() * 70 + 10 + 'vw';
                    this.style.zIndex = '1000';
                } else {
                    this.style.position = 'static';
                    this.textContent = 'FINE! BUY IT!';
                }
            });
        });
        
        function buyProduct(product) {
            if(!confirm("⚠️ CONFIRM PURCHASE ⚠️\n\nAre you ABSOLUTELY sure you want to buy " + product + "?\n\n(Remember: This is a demo. No actual purchase will be made)")) {
                alert("Purchase cancelled!\n\nGood choice. Your wallet thanks you.");
                return;
            }
            
            if(!confirm("⚠️ FINAL CONFIRMATION ⚠️\n\nLast chance to back out!\n\nReally want " + product + "?")) {
                alert("Smart decision! Cancelled.");
                return;
            }
            
            // Random fake price
            const price = (Math.random() * 500 + 50).toFixed(2);
            alert("💳 PROCESSING PAYMENT...\n\nProduct: " + product + "\nTotal: $" + price + "\n\nPlease wait...");
            
            setTimeout(() => {
                if(Math.random() < 0.4) {
                    alert("❌ PAYMENT FAILED!\n\nError Code: INSUFFICIENT_FUNDS_" + Math.floor(Math.random() * 9000 + 1000) + "\n\nJust kidding! This is a demo.\n\n(But imagine if it was real. Scary, right?)");
                } else {
                    alert("✅ ORDER SUCCESSFUL!\n\nProduct: " + product + "\nAmount Charged: $" + price + "\n\nDelivery: 6-8 weeks\n\n...In an alternate reality where this isn't a demo!");
                    
                    setTimeout(() => {
                        alert("📧 SHIPPING UPDATE\n\nYour order has been:\n- Processed\n- Packaged\n- Lost in transit\n- Found again\n- Delivered to wrong address\n\n(All in the span of 3 seconds. Technology is amazing!)");
                    }, 2000);
                }
            }, 1500);
        }
        
        function showEmergency() {
            document.getElementById('emergency-popup').style.display = 'block';
            
            setTimeout(() => {
                alert("⚠️ HEALTH TIP ⚠️\n\nDid you know?\n\n- Your bones are wet right now\n- You can't breathe and swallow at the same time\n- You just tried that, didn't you?\n\nThe human body is fascinating and weird.");
            }, 3000);
        }
        
        function closeEmergency() {
            if(confirm("Are you sure you want to close this important health information?\n\nIt could save your life!\n\n(It won't, but it sounds dramatic)")) {
                document.getElementById('emergency-popup').style.display = 'none';
            }
        }
        
        // Annoying welcome alert
        setTimeout(() => {
            alert("🎉 WELCOME TO HEALTHMART! 🎉\n\nYour one-stop shop for all your health needs!\n\n(And by 'needs' we mean 'things we'll try to sell you')");
        }, 2000);
        
        setTimeout(() => {
            if(confirm("📱 NOTIFICATION PERMISSION 📱\n\nHealthMart would like to send you notifications.\n\n(We'll send you one every 5 minutes. Sounds fun, right?)")) {
                alert("✅ NOTIFICATIONS ENABLED!\n\nYou'll now receive:\n- Daily health tips\n- Hourly sale alerts\n- Constant product updates\n- Random motivational quotes\n- This was a bad decision alert");
            } else {
                alert("❌ NOTIFICATIONS BLOCKED\n\nYou've made a wise choice.\n\n...but we'll ask again in 5 minutes.");
            }
        }, 5000);
        
        // Random health tips that interrupt
        const healthTips = [
            "💡 HEALTH TIP: Drink water! Unless you're drowning. Then don't.",
            "💡 TIP OF THE DAY: An apple a day keeps the doctor away. A doctor's bill a day keeps your savings away.",
            "💡 WELLNESS FACT: Getting punched in the face burns 300 calories. (Don't try this)",
            "💡 DID YOU KNOW: 'Stressed' spelled backwards is 'desserts'. Coincidence? We think not.",
            "💡 HEALTH REMINDER: If you're reading this, you're alive! Congratulations!",
        ];
        
        setInterval(() => {
            if(Math.random() < 0.2) {
                alert(healthTips[Math.floor(Math.random() * healthTips.length)]);
            }
        }, 15000);
        
        // Random page scrolling
        setInterval(() => {
            if(Math.random() < 0.15) {
                window.scrollTo({
                    top: Math.random() * document.body.scrollHeight,
                    behavior: 'smooth'
                });
            }
        }, 12000);
        
        // Create random floating elements
        setInterval(() => {
            const emojis = ['💊', '💉', '🏥', '⚕️', '🩺', '💊', '🧪', '🩹'];
            const emoji = emojis[Math.floor(Math.random() * emojis.length)];
            const element = document.createElement('div');
            element.style.position = 'fixed';
            element.style.left = Math.random() * 90 + 'vw';
            element.style.top = '-50px';
            element.style.fontSize = '40px';
            element.innerHTML = emoji;
            element.style.transition = 'top 5s linear';
            element.style.pointerEvents = 'none';
            element.style.zIndex = '500';
            document.body.appendChild(element);
            
            setTimeout(() => {
                element.style.top = '110vh';
            }, 100);
            
            setTimeout(() => element.remove(), 5500);
        }, 2000);
        
        // Flash random popups
        function createSalePopup() {
            const messages = [
                "🔥 FLASH SALE! Everything must go!",
                "💰 SPECIAL DISCOUNT! Click here!",
                "⭐ NEW ARRIVAL! Check it out!",
                "🎁 FREE GIFT with purchase!",
                "⚡ LIMITED TIME OFFER!",
                "🏆 YOU'RE OUR 1000000th VISITOR!"
            ];
            
            const popup = document.createElement('div');
            popup.style.cssText = 'position:fixed;background:#ff00ff;border:5px solid #ffff00;padding:20px;border-radius:15px;z-index:9999;box-shadow:0 0 30px rgba(0,0,0,0.8);font-size:18px;font-weight:bold;cursor:pointer;animation:shake 0.5s infinite;';
            popup.style.top = Math.random() * 70 + 10 + 'vh';
            popup.style.left = Math.random() * 70 + 10 + 'vw';
            popup.innerHTML = messages[Math.floor(Math.random() * messages.length)];
            popup.onclick = function() {
                alert("🎉 CONGRATULATIONS! 🎉\n\nYou've won absolutely nothing!\n\nBut thanks for clicking!");
                this.remove();
            };
            
            document.body.appendChild(popup);
            setTimeout(() => popup.remove(), 5000);
        }
        
        setInterval(createSalePopup, 6000);
        
        // Random shake effect
        setInterval(() => {
            if(Math.random() < 0.1) {
                document.body.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    document.body.style.animation = '';
                }, 500);
            }
        }, 10000);
        
        // Fake loading screens
        setTimeout(() => {
            const loading = document.createElement('div');
            loading.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.95);z-index:99999;display:flex;align-items:center;justify-content:center;color:white;font-size:30px;flex-direction:column;';
            loading.innerHTML = '<div style="font-size:60px;">⏳</div><br>LOADING SPECIAL OFFERS...<br><br><div style="width:300px;height:30px;border:3px solid white;border-radius:15px;overflow:hidden;"><div id="progress-bar" style="width:0%;height:100%;background:linear-gradient(90deg,#ff0000,#00ff00,#0000ff);transition:width 0.1s;"></div></div>';
            document.body.appendChild(loading);
            
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if(progress >= 100) {
                    progress = 100;
                    clearInterval(progressInterval);
                    setTimeout(() => {
                        loading.remove();
                        alert("✅ LOADING COMPLETE!\n\nWow, that was pointless!\n\nThe page was already loaded. We just made you wait for fun!");
                    }, 500);
                }
                document.getElementById('progress-bar').style.width = progress + '%';
            }, 300);
        }, 8000);
        
        // Cursor interference
        const cursors = ['wait', 'not-allowed', 'grab', 'crosshair', 'move', 'progress'];
        setInterval(() => {
            if(Math.random() < 0.15) {
                document.body.style.cursor = cursors[Math.floor(Math.random() * cursors.length)];
                setTimeout(() => {
                    document.body.style.cursor = '';
                }, 3000);
            }
        }, 8000);
        
        // Logout warning
        setTimeout(() => {
            alert("⚠️ INACTIVITY WARNING ⚠️\n\nYou will be logged out in 30 seconds due to inactivity.\n\n(Just kidding. You literally just got here.)");
        }, 20000);
    </script>
</body>
</html>
