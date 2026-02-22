<?php
session_start();

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
    <title>FIRST AID GUIDE - EMERGENCY CHAOS!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: repeating-conic-gradient(#ff0000 0% 25%, #ffff00 0% 50%, #00ff00 0% 75%, #0000ff 0% 100%);
            background-size: 50px 50px;
            font-family: 'Comic Sans MS', cursive;
            padding: 20px;
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
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
        
        .header {
            text-align: center;
            background: #ff0000;
            color: #ffff00;
            padding: 40px;
            border: 15px solid #000;
            margin-bottom: 30px;
            animation: shake 2s infinite;
        }
        
        .header h1 {
            font-size: 60px;
            text-shadow: 5px 5px #000;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .warning {
            background: #ffff00;
            border: 10px double #ff0000;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            animation: blink 2s infinite;
        }
        
        .emergency-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .emergency-card {
            background: rgba(255, 255, 255, 0.95);
            border: 8px solid;
            border-radius: 25px;
            padding: 30px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .emergency-card:hover {
            transform: scale(1.05) rotate(2deg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .emergency-card h3 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        
        .emergency-card ul {
            list-style: none;
            padding: 0;
        }
        
        .emergency-card li {
            padding: 10px;
            margin: 8px 0;
            background: #f0f0f0;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .emergency-card:nth-child(1) {
            border-color: #e74c3c;
        }
        
        .emergency-card:nth-child(2) {
            border-color: #3498db;
        }
        
        .emergency-card:nth-child(3) {
            border-color: #2ecc71;
        }
        
        .emergency-card:nth-child(4) {
            border-color: #f39c12;
        }
        
        .emergency-card:nth-child(5) {
            border-color: #9b59b6;
        }
        
        .emergency-card:nth-child(6) {
            border-color: #1abc9c;
        }
        
        .step-number {
            display: inline-block;
            background: #ff0000;
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .emergency-number {
            background: #ff0000;
            color: #fff;
            padding: 40px;
            margin: 30px 0;
            border: 10px solid #000;
            border-radius: 30px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        
        .emergency-number h2 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .emergency-number .number {
            font-size: 96px;
            font-weight: bold;
            text-shadow: 5px 5px #000;
            animation: pulse 1s infinite;
        }
        
        .checklist {
            background: rgba(255, 255, 255, 0.95);
            border: 8px solid #00ff00;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .checklist h2 {
            font-size: 36px;
            color: #ff0000;
            margin-bottom: 20px;
        }
        
        .checklist-item {
            padding: 15px;
            margin: 10px 0;
            background: #e6ffe6;
            border: 3px solid #00aa00;
            border-radius: 10px;
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        
        .checklist-item input[type="checkbox"] {
            width: 25px;
            height: 25px;
            margin-right: 15px;
            cursor: pointer;
        }
        
        marquee {
            background: #ff0000;
            color: #ffff00;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            border: 5px solid #000;
            margin: 20px 0;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border: 15px solid #ff0000;
            border-radius: 30px;
            padding: 40px;
            max-width: 700px;
            max-height: 80vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.8);
        }
        
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }
        
        .close-modal {
            background: #ff0000;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 20px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }
        
        .disclaimer-box {
            background: #ffe6e6;
            border: 5px dashed #ff0000;
            padding: 20px;
            border-radius: 15px;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <a href="index.php" class="nav-back">← BACK TO CHAOS</a>
    
    <div class="header">
        <h1>�‍⚕️ FIRST AID GUIDE 👨‍⚕️</h1>
        <p style="font-size: 24px;">BECAUSE EMERGENCIES DON'T WAIT!</p>
    </div>
    
    <marquee behavior="scroll" direction="left">
        ⚠️ IN A REAL EMERGENCY, CALL 911 FIRST, THEN READ THIS! ⚠️
    </marquee>
    
    <div class="container">
        <div class="warning">
            ⚠️ THIS IS EDUCATIONAL! FOR REAL EMERGENCIES, CALL 911! ⚠️
        </div>
        
        <!-- Emergency Number -->
        <div class="emergency-number">
            <h2>⚠️ EMERGENCY NUMBER ⚠️</h2>
            <div class="number">911</div>
            <p style="font-size: 24px; margin-top: 20px;">
                In the United States, dial 911 for emergencies.<br>
                Know your location and stay calm!
            </p>
        </div>
        
        <!-- Common Emergencies -->
        <h2 style="text-align: center; font-size: 48px; color: #fff; text-shadow: 3px 3px #000; margin: 30px 0;">
            COMMON FIRST AID SITUATIONS
        </h2>
        
        <div class="emergency-grid">
            <div class="emergency-card" onclick="showModal('cuts')">
                <h3>🩹 CUTS & BLEEDING</h3>
                <p style="font-size: 18px; margin-bottom: 15px;">Click for details →</p>
                <ul>
                    <li>✓ Apply direct pressure</li>
                    <li>✓ Elevate if possible</li>
                    <li>✓ Clean and bandage</li>
                    <li>✓ Seek help for severe bleeding</li>
                </ul>
            </div>
            
            <div class="emergency-card" onclick="showModal('burns')">
                <h3>🔥 BURNS</h3>
                <p style="font-size: 18px; margin-bottom: 15px;">Click for details →</p>
                <ul>
                    <li>✓ Cool with running water</li>
                    <li>✓ Don't use ice</li>
                    <li>✓ Cover with clean cloth</li>
                    <li>✓ Don't pop blisters</li>
                </ul>
            </div>
            
            <div class="emergency-card" onclick="showModal('choking')">
                <h3>⚠️ CHOKING</h3>
                <p style="font-size: 18px; margin-bottom: 15px;">Click for details →</p>
                <ul>
                    <li>✓ Encourage coughing</li>
                    <li>✓ Heimlich maneuver if needed</li>
                    <li>✓ Call 911 if severe</li>
                    <li>✓ Back blows between shoulders</li>
                </ul>
            </div>
            
            <div class="emergency-card" onclick="showModal('cpr')">
                <h3>❤️ CPR BASICS</h3>
                <p style="font-size: 18px; margin-bottom: 15px;">Click for details →</p>
                <ul>
                    <li>✓ Call 911 immediately</li>
                    <li>✓ 30 chest compressions</li>
                    <li>✓ 2 rescue breaths</li>
                    <li>✓ Repeat until help arrives</li>
                </ul>
            </div>
            
            <div class="emergency-card" onclick="showModal('allergic')">
                <h3>⚠️ ALLERGIC REACTION</h3>
                <p style="font-size: 18px; margin-bottom: 15px;">Click for details →</p>
                <ul>
                    <li>✓ Use EpiPen if available</li>
                    <li>✓ Call 911 immediately</li>
                    <li>✓ Keep person calm</li>
                    <li>✓ Monitor breathing</li>
                </ul>
            </div>
            
            <div class="emergency-card" onclick="showModal('fracture')">
                <h3>� FRACTURES/SPRAINS</h3>
                <p style="font-size: 18px; margin-bottom: 15px;">Click for details →</p>
                <ul>
                    <li>✓ Don't move injured area</li>
                    <li>✓ Apply ice (not directly)</li>
                    <li>✓ Immobilize if possible</li>
                    <li>✓ Seek medical attention</li>
                </ul>
            </div>
        </div>
        
        <!-- First Aid Kit Checklist -->
        <div class="checklist">
            <h2>� FIRST AID KIT ESSENTIALS</h2>
            <p style="font-size: 18px; margin-bottom: 20px;">Check off what you have in your first aid kit:</p>
            
            <div class="checklist-item">
                <input type="checkbox" id="item1">
                <label for="item1">Adhesive bandages (various sizes)</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item2">
                <label for="item2">Sterile gauze pads</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item3">
                <label for="item3">Medical tape</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item4">
                <label for="item4">Antiseptic wipes/solution</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item5">
                <label for="item5">Antibiotic ointment</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item6">
                <label for="item6">Scissors and tweezers</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item7">
                <label for="item7">Disposable gloves</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item8">
                <label for="item8">Pain relievers (ibuprofen, acetaminophen)</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item9">
                <label for="item9">Thermometer</label>
            </div>
            <div class="checklist-item">
                <input type="checkbox" id="item10">
                <label for="item10">Emergency contact numbers</label>
            </div>
        </div>
        
        <!-- Disclaimer -->
        <div class="disclaimer-box">
            <h3 style="color: #ff0000; font-size: 24px; margin-bottom: 15px;">⚠️ IMPORTANT DISCLAIMER</h3>
            <p style="font-size: 16px; line-height: 1.6;">
                This guide provides basic first aid information for educational purposes only. It is NOT a substitute for professional medical training or emergency services.
                <br><br>
                <strong>ALWAYS CALL 911 in true emergencies!</strong>
                <br><br>
                Consider taking a certified First Aid/CPR course from organizations like the American Red Cross or American Heart Association for proper hands-on training.
                <br><br>
                When in doubt, seek professional medical help!
            </p>
        </div>
    </div>
    
    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modal-overlay" onclick="closeModal()"></div>
    
    <!-- Modals for each emergency type -->
    <div class="modal" id="modal-cuts">
        <h2 style="font-size: 36px; color: #e74c3c; margin-bottom: 20px;">🩹 CUTS & BLEEDING</h2>
        <div style="font-size: 18px; line-height: 1.8;">
            <p><span class="step-number">1</span> <strong>Wash your hands</strong> before treating the wound</p>
            <p><span class="step-number">2</span> <strong>Apply direct pressure</strong> with a clean cloth or bandage for 5-10 minutes</p>
            <p><span class="step-number">3</span> <strong>Elevate</strong> the injured area above the heart if possible</p>
            <p><span class="step-number">4</span> Once bleeding stops, <strong>clean</strong> the wound with water</p>
            <p><span class="step-number">5</span> Apply <strong>antibiotic ointment</strong> and cover with bandage</p>
            <p><span class="step-number">6</span> Change bandage daily and watch for infection</p>
            <br>
            <p style="background: #ffe6e6; padding: 15px; border-radius: 10px;">
                <strong>⚠️ Seek immediate medical help if:</strong><br>
                • Bleeding doesn't stop after 10 minutes of pressure<br>
                • The cut is deep or gaping<br>
                • You can see fat, muscle, or bone<br>
                • The wound is from a dirty or rusty object<br>
                • Signs of infection appear (redness, swelling, pus)
            </p>
        </div>
        <button class="close-modal" onclick="closeModal()">CLOSE</button>
    </div>
    
    <div class="modal" id="modal-burns">
        <h2 style="font-size: 36px; color: #f39c12; margin-bottom: 20px;">🔥 BURNS</h2>
        <div style="font-size: 18px; line-height: 1.8;">
            <p><span class="step-number">1</span> <strong>Remove</strong> from heat source immediately</p>
            <p><span class="step-number">2</span> <strong>Cool</strong> the burn under running cool (not cold) water for 10-20 minutes</p>
            <p><span class="step-number">3</span> <strong>Remove</strong> jewelry or tight clothing near the burn</p>
            <p><span class="step-number">4</span> <strong>Cover</strong> with a sterile, non-stick bandage or clean cloth</p>
            <p><span class="step-number">5</span> <strong>Do NOT</strong> apply ice, butter, or ointments</p>
            <p><span class="step-number">6</span> <strong>Do NOT</strong> pop blisters</p>
            <br>
            <p style="background: #ffe6e6; padding: 15px; border-radius: 10px;">
                <strong>⚠️ Call 911 for:</strong><br>
                • Burns larger than 3 inches<br>
                • Burns on face, hands, feet, or genitals<br>
                • Third-degree burns (white or charred skin)<br>
                • Chemical or electrical burns<br>
                • Burns in children or elderly
            </p>
        </div>
        <button class="close-modal" onclick="closeModal()">CLOSE</button>
    </div>
    
    <div class="modal" id="modal-choking">
        <h2 style="font-size: 36px; color: #e74c3c; margin-bottom: 20px;">⚠️ CHOKING</h2>
        <div style="font-size: 18px; line-height: 1.8;">
            <p><strong>If person can cough or speak:</strong></p>
            <p><span class="step-number">1</span> Encourage them to keep <strong>coughing</strong></p>
            <p><span class="step-number">2</span> Stay with them and monitor</p>
            <br>
            <p><strong>If person cannot breathe, cough, or speak:</strong></p>
            <p><span class="step-number">1</span> <strong>Call 911</strong> immediately</p>
            <p><span class="step-number">2</span> Perform <strong>5 back blows</strong> between shoulder blades with heel of hand</p>
            <p><span class="step-number">3</span> If that doesn't work, perform <strong>Heimlich maneuver</strong>:</p>
            <p style="margin-left: 40px;">• Stand behind person, arms around waist</p>
            <p style="margin-left: 40px;">• Make fist above navel, below ribcage</p>
            <p style="margin-left: 40px;">• Grasp fist with other hand</p>
            <p style="margin-left: 40px;">• Give quick, upward thrusts</p>
            <p><span class="step-number">4</span> Repeat back blows and Heimlich until object dislodges or help arrives</p>
            <br>
            <p style="background: #ffe6e6; padding: 15px; border-radius: 10px;">
                <strong>⚠️ Note:</strong> Proper Heimlich technique requires training. Take a First Aid course to learn correctly!
            </p>
        </div>
        <button class="close-modal" onclick="closeModal()">CLOSE</button>
    </div>
    
    <div class="modal" id="modal-cpr">
        <h2 style="font-size: 36px; color: #e74c3c; margin-bottom: 20px;">❤️ CPR BASICS</h2>
        <div style="font-size: 18px; line-height: 1.8;">
            <p><span class="step-number">1</span> <strong>CALL 911 FIRST!</strong> Put phone on speaker</p>
            <p><span class="step-number">2</span> Check if person is responsive and breathing</p>
            <p><span class="step-number">3</span> If not breathing, begin <strong>chest compressions</strong>:</p>
            <p style="margin-left: 40px;">• Place heel of hand on center of chest</p>
            <p style="margin-left: 40px;">• Place other hand on top, interlace fingers</p>
            <p style="margin-left: 40px;">• Press down 2 inches deep</p>
            <p style="margin-left: 40px;">• Compress at rate of 100-120 per minute</p>
            <p style="margin-left: 40px;">• (Sing "Stayin' Alive" for the correct rhythm!)</p>
            <p><span class="step-number">4</span> After 30 compressions, give <strong>2 rescue breaths</strong></p>
            <p><span class="step-number">5</span> Continue 30:2 ratio until:</p>
            <p style="margin-left: 40px;">• Person starts breathing</p>
            <p style="margin-left: 40px;">• EMS arrives</p>
            <p style="margin-left: 40px;">• AED is available</p>
            <p style="margin-left: 40px;">• You're too exhausted to continue</p>
            <br>
            <p style="background: #ffe6e6; padding: 15px; border-radius: 10px;">
                <strong>⚠️ CRITICAL:</strong> This is a basic overview! Take a certified CPR course from American Red Cross or American Heart Association for proper training. Hands-on practice is essential!
            </p>
        </div>
        <button class="close-modal" onclick="closeModal()">CLOSE</button>
    </div>
    
    <div class="modal" id="modal-allergic">
        <h2 style="font-size: 36px; color: #9b59b6; margin-bottom: 20px;">⚠️ SEVERE ALLERGIC REACTION</h2>
        <div style="font-size: 18px; line-height: 1.8;">
            <p><strong>Anaphylaxis signs:</strong> Difficulty breathing, swelling of face/throat, rapid pulse, dizziness, rash</p>
            <br>
            <p><span class="step-number">1</span> <strong>Call 911 IMMEDIATELY</strong></p>
            <p><span class="step-number">2</span> If person has an <strong>EpiPen</strong>:</p>
            <p style="margin-left: 40px;">• Remove safety cap</p>
            <p style="margin-left: 40px;">• Place against outer thigh (can go through clothes)</p>
            <p style="margin-left: 40px;">• Press firmly and hold for 3 seconds</p>
            <p style="margin-left: 40px;">• Massage area for 10 seconds</p>
            <p><span class="step-number">3</span> Have person <strong>lie down</strong> with legs elevated</p>
            <p><span class="step-number">4</span> <strong>Monitor</strong> breathing and pulse</p>
            <p><span class="step-number">5</span> If no improvement in 5-15 minutes and second EpiPen available, give second dose</p>
            <p><span class="step-number">6</span> Even if symptoms improve, <strong>emergency care is still needed</strong></p>
            <br>
            <p style="background: #ffe6e6; padding: 15px; border-radius: 10px;">
                <strong>⚠️ Important:</strong> Anaphylaxis is LIFE-THREATENING. Always call 911 even if EpiPen is used!
            </p>
        </div>
        <button class="close-modal" onclick="closeModal()">CLOSE</button>
    </div>
    
    <div class="modal" id="modal-fracture">
        <h2 style="font-size: 36px; color: #1abc9c; margin-bottom: 20px;">� FRACTURES & SPRAINS</h2>
        <div style="font-size: 18px; line-height: 1.8;">
            <p><span class="step-number">1</span> <strong>Do NOT move</strong> the injured area</p>
            <p><span class="step-number">2</span> <strong>Call 911</strong> for obvious fractures or severe injuries</p>
            <p><span class="step-number">3</span> <strong>Immobilize</strong> the area if possible:</p>
            <p style="margin-left: 40px;">• Use splint or rolled newspaper/magazine</p>
            <p style="margin-left: 40px;">• Secure above and below injury</p>
            <p style="margin-left: 40px;">• Don't try to realign</p>
            <p><span class="step-number">4</span> <strong>Apply ice</strong> wrapped in cloth (not directly on skin)</p>
            <p><span class="step-number">5</span> <strong>Elevate</strong> if possible</p>
            <p><span class="step-number">6</span> <strong>For sprains</strong>, remember RICE:</p>
            <p style="margin-left: 40px;">• <strong>R</strong>est the injury</p>
            <p style="margin-left: 40px;">• <strong>I</strong>ce for 20 minutes at a time</p>
            <p style="margin-left: 40px;">• <strong>C</strong>ompression with elastic bandage</p>
            <p style="margin-left: 40px;">• <strong>E</strong>levate above heart level</p>
            <br>
            <p style="background: #ffe6e6; padding: 15px; border-radius: 10px;">
                <strong>⚠️ Seek medical attention if:</strong><br>
                • Severe pain, swelling, or deformity<br>
                • Loss of feeling or circulation<br>
                • Open wound with bone visible<br>
                • Unable to bear weight
            </p>
        </div>
        <button class="close-modal" onclick="closeModal()">CLOSE</button>
    </div>
    
    <marquee behavior="scroll" direction="right">
        REMEMBER: First aid knowledge can save lives! Consider taking a certified course!
    </marquee>
    
    <script>
        function showModal(type) {
            document.getElementById('modal-overlay').style.display = 'block';
            document.getElementById('modal-' + type).style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('modal-overlay').style.display = 'none';
            document.querySelectorAll('.modal').forEach(modal => {
                modal.style.display = 'none';
            });
        }
        
        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if(e.key === 'Escape') {
                closeModal();
            }
        });
        
        // Educational popup
        setTimeout(() => {
            alert('EDUCATIONAL REMINDER\n\nIn an emergency, knowing CPR from a website is like knowing karate from watching movies.\n\nIt might help, but you really want the real training.\n\nTake a certified course (American Red Cross / AHA).\n\nFirst aid knowledge can literally save lives.');
        }, 2000);
        
        // Disable right-click and copy
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        
        // Random safety tips
        setInterval(() => {
            if(Math.random() < 0.15) {
                const tips = [
                    "⚠️ REMINDER: Call 911 for real emergencies!",
                    "💡 TIP: Know where your nearest hospital is!",
                    "🏥 FACT: First aid training actually works!",
                    "⚕️ NOTE: This website is NOT a substitute for real medical care!"
                ];
                alert(tips[Math.floor(Math.random() * tips.length)]);
            }
        }, 18000);
        
        // Make buttons harder to click
        document.querySelectorAll('.emergency-card').forEach((card, idx) => {
            let clickCount = 0;
            card.addEventListener('click', function(e) {
                clickCount++;
                if(clickCount === 1 && Math.random() < 0.4) {
                    e.stopPropagation();
                    e.preventDefault();
                    alert("🚨 WAIT! 🚨\n\nAre you sure you want to learn about this?\n\nIt might be graphic!\n\n(Click again to proceed)");
                }
            });
        });
    </script>
</body>
</html>
