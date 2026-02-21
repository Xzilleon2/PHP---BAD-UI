<?php
session_start();

if(!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

$triage = '';
$color = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pain = intval($_POST['pain'] ?? 0);
    $consciousness = $_POST['consciousness'] ?? '';
    $breathing = $_POST['breathing'] ?? '';
    $bleeding = $_POST['bleeding'] ?? '';
    
    $score = 0;
    
    // Calculate urgency score
    if($pain >= 8) $score += 3;
    elseif($pain >= 5) $score += 2;
    elseif($pain >= 3) $score += 1;
    
    if($consciousness === 'confused' || $consciousness === 'unconscious') $score += 4;
    elseif($consciousness === 'drowsy') $score += 2;
    
    if($breathing === 'none' || $breathing === 'severe') $score += 5;
    elseif($breathing === 'difficult') $score += 2;
    
    if($bleeding === 'severe') $score += 4;
    elseif($bleeding === 'moderate') $score += 2;
    elseif($bleeding === 'minor') $score += 1;
    
    // Determine triage level
    if($score >= 10) {
        $color = 'red';
        $triage = '⚠️ EMERGENCY! CALL 911 NOW! ⚠️<br><br>Okay, we\'re being serious for a moment: If you\'re actually experiencing severe symptoms, please call emergency services immediately. This is not a joke!<br><br>But if you\'re just testing this tool for fun... you got us!';
    } elseif($score >= 6) {
        $color = 'orange';
        $triage = '⚠️ URGENT CARE NEEDED! ⚠️<br><br>You should probably see a doctor soon. Like, today if possible. But you\'re probably not dying... probably.<br><br>(Again, if real emergency: CALL 911!)';
    } elseif($score >= 3) {
        $color = 'yellow';
        $triage = 'MODERATE CONCERN<br><br>You might want to schedule a doctor\'s appointment in the next few days. Or maybe just take some ibuprofen and see how you feel tomorrow?<br><br>You\'re probably fine!';
    } else {
        $color = 'green';
        $triage = '✅ YOU\'RE FINE! ✅<br><br>Congratulations! You\'re not dying today!<br><br>Go drink some water, take a nap, and stop Googling symptoms!<br><br>See you next time you have a hangnail!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AM I DYING?! - DRAMATIC HEALTH TRIAGE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #000;
            color: #fff;
            font-family: 'Comic Sans MS', cursive;
            padding: 20px;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        @keyframes siren {
            0%, 100% { background: #ff0000; }
            50% { background: #0000ff; }
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
            color: #000;
            padding: 40px;
            border: 10px solid #ffff00;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }
        
        .header h1 {
            font-size: 60px;
            text-shadow: 5px 5px #ffff00;
            animation: shake 0.5s infinite;
        }
        
        .skull {
            font-size: 100px;
            animation: pulse 1s infinite;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border: 15px double #ff0000;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 0 100px rgba(255, 0, 0, 0.8);
            color: #000;
        }
        
        .warning-banner {
            background: #ffff00;
            border: 5px solid #ff0000;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            animation: blink 2s infinite;
        }
        
        .question-section {
            margin: 30px 0;
            padding: 25px;
            border: 5px solid #ff0000;
            border-radius: 15px;
            background: #ffe6e6;
        }
        
        .question-section h3 {
            font-size: 24px;
            color: #ff0000;
            margin-bottom: 15px;
        }
        
        .pain-slider {
            width: 100%;
            height: 50px;
            margin: 20px 0;
        }
        
        .pain-scale {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }
        
        .pain-value {
            font-size: 48px;
            text-align: center;
            color: #ff0000;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .pain-faces {
            display: flex;
            justify-content: space-around;
            font-size: 40px;
            margin: 20px 0;
        }
        
        .radio-group {
            margin: 15px 0;
        }
        
        .radio-option {
            display: block;
            padding: 15px;
            margin: 10px 0;
            background: #fff;
            border: 3px solid #0000ff;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .radio-option:hover {
            background: #e6e6ff;
            transform: scale(1.02);
        }
        
        .radio-option input {
            margin-right: 10px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .radio-option label {
            font-size: 18px;
            cursor: pointer;
        }
        
        .submit-btn {
            width: 100%;
            padding: 40px;
            font-size: 40px;
            background: linear-gradient(45deg, #ff0000, #000000);
            color: #fff;
            border: 10px solid #ffff00;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 3px 3px #000;
            margin-top: 30px;
            animation: pulse 2s infinite;
        }
        
        .submit-btn:hover {
            animation: shake 0.3s infinite;
        }
        
        .result-box {
            margin-top: 30px;
            padding: 40px;
            border: 15px solid;
            border-radius: 20px;
            text-align: center;
            font-size: 24px;
        }
        
        .result-red {
            background: #ff0000;
            border-color: #660000;
            color: #fff;
            animation: siren 1s infinite;
        }
        
        .result-orange {
            background: #ffa500;
            border-color: #ff4500;
            color: #000;
        }
        
        .result-yellow {
            background: #ffff00;
            border-color: #ff8800;
            color: #000;
        }
        
        .result-green {
            background: #00ff00;
            border-color: #006600;
            color: #000;
        }
        
        .result-box h2 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        .disclaimer {
            margin-top: 30px;
            padding: 20px;
            background: #f0f0f0;
            border: 5px dashed #ff0000;
            border-radius: 10px;
        }
        
        .disclaimer h3 {
            color: #ff0000;
            margin-bottom: 10px;
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
    </style>
</head>
<body>
    <a href="index.php" class="nav-back">← ESCAPE BACK TO SAFETY</a>
    
    <div class="header">
        <div class="skull">⚠️</div>
        <h1>AM I DYING?!</h1>
        <p style="font-size: 24px; margin-top: 10px;">DRAMATIC TRIAGE ASSESSMENT TOOL</p>
    </div>
    
    <marquee behavior="scroll" direction="left">
        ⚠️ EMERGENCY DISCLAIMER: IF YOU ARE ACTUALLY IN AN EMERGENCY, CLOSE THIS WEBSITE AND CALL 911! ⚠️
    </marquee>
    
    <div class="container">
        <div class="warning-banner">
            ⚠️ THIS IS SATIRE! FOR REAL EMERGENCIES, CALL 911! ⚠️
        </div>
        
        <div style="text-align: center; margin: 20px 0;">
            <h2 style="font-size: 32px; color: #ff0000;">ANSWER THESE QUESTIONS HONESTLY:</h2>
            <p style="font-size: 18px; margin-top: 10px;">(Or don't, we're not your doctor)</p>
        </div>
        
        <form method="POST" id="triage-form">
            <!-- Pain Level -->
            <div class="question-section">
                <h3>PAIN LEVEL (0-10):</h3>
                <p style="margin-bottom: 15px;">Rate your pain from 0 (no pain) to 10 (worst pain imaginable)</p>
                
                <input type="range" min="0" max="10" value="5" class="pain-slider" id="pain-slider" name="pain" oninput="updatePain(this.value)">
                
                <div class="pain-value" id="pain-value">5</div>
                
                <div class="pain-faces">
                    <span title="0: No pain">0</span>
                    <span title="2-3: Mild">3</span>
                    <span title="4-6: Moderate">5</span>
                    <span title="7-8: Severe">8</span>
                    <span title="9-10: Worst">10</span>
                </div>
                
                <div class="pain-scale">
                    <span>No Pain (0)</span>
                    <span>Worst Pain Ever (10)</span>
                </div>
            </div>
            
            <!-- Consciousness -->
            <div class="question-section">
                <h3>CONSCIOUSNESS LEVEL:</h3>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="consciousness" value="alert" id="c1" required>
                        <label for="c1">Fully Alert (reading this stupid form)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="consciousness" value="drowsy" id="c2">
                        <label for="c2">Drowsy (but that could just be Monday)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="consciousness" value="confused" id="c3">
                        <label for="c3">Confused (more than usual)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="consciousness" value="unconscious" id="c4">
                        <label for="c4">⚠️ Unconscious (if you can click this, you're not)</label>
                    </div>
                </div>
            </div>
            
            <!-- Breathing -->
            <div class="question-section">
                <h3>BREATHING:</h3>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="breathing" value="normal" id="b1" required>
                        <label for="b1">✅ Normal (in through nose, out through mouth)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="breathing" value="difficult" id="b2">
                        <label for="b2">Difficult (but I also just climbed stairs)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="breathing" value="severe" id="b3">
                        <label for="b3">⚠️ Severely Difficult (gasping)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="breathing" value="none" id="b4">
                        <label for="b4">⚠️ Not Breathing (then how are you clicking?)</label>
                    </div>
                </div>
            </div>
            
            <!-- Bleeding -->
            <div class="question-section">
                <h3>BLEEDING:</h3>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="bleeding" value="none" id="bl1" required>
                        <label for="bl1">✅ No Bleeding (intact human)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="bleeding" value="minor" id="bl2">
                        <label for="bl2">Minor (paper cut level)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="bleeding" value="moderate" id="bl3">
                        <label for="bl3">Moderate (needs bandage)</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="bleeding" value="severe" id="bl4">
                        <label for="bl4">⚠️ Severe (STOP FILLING OUT FORMS AND CALL 911!)</label>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">
                ⚠️ TELL ME IF I'M DYING! ⚠️
            </button>
        </form>
        
        <?php if($triage): ?>
        <div class="result-box result-<?php echo $color; ?>">
            <h2>TRIAGE RESULT</h2>
            <div style="margin-top: 20px; font-size: 24px; line-height: 1.6;">
                <?php echo $triage; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="disclaimer">
            <h3>⚠️ IMPORTANT DISCLAIMER:</h3>
            <p style="font-size: 16px; line-height: 1.6;">
                This tool is <strong>FOR ENTERTAINMENT PURPOSES ONLY</strong>. It is NOT a substitute for professional medical advice, diagnosis, or treatment.
                <br><br>
                <strong>WHEN TO CALL 911:</strong>
                <br>• Chest pain or pressure
                <br>• Difficulty breathing
                <br>• Severe bleeding that won't stop
                <br>• Loss of consciousness
                <br>• Severe allergic reaction
                <br>• Stroke symptoms (FAST: Face drooping, Arm weakness, Speech difficulty, Time to call 911)
                <br><br>
                When in doubt, seek professional medical help. Don't rely on a satirical website!
            </p>
        </div>
    </div>
    
    <marquee behavior="scroll" direction="right">
        HEALTH TIP: If you can read this scrolling text, you're probably not dying right now!
    </marquee>
    
    <script>
        function updatePain(value) {
            document.getElementById('pain-value').textContent = value;
            
            const painDisplay = document.getElementById('pain-value');
            if(value >= 8) {
                painDisplay.style.color = '#ff0000';
                painDisplay.style.animation = 'blink 0.5s infinite';
            } else if(value >= 5) {
                painDisplay.style.color = '#ff8800';
                painDisplay.style.animation = 'none';
            } else {
                painDisplay.style.color = '#00aa00';
                painDisplay.style.animation = 'none';
            }
        }
        
        // Warning for severe selections
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                if(e.target.value === 'severe' || e.target.value === 'unconscious' || e.target.value === 'none') {
                    alert('⚠️ CRITICAL WARNING! ⚠️\n\nIf this is real: STOP CLICKING THINGS AND DIAL 911.\n\nWe\'re a satirical website, not a miracle worker.\n\nEmergency services > Comedy health websites.');
                }
            });
        });
        
        document.getElementById('triage-form').addEventListener('submit', (e) => {
            const pain = parseInt(document.getElementById('pain-slider').value);
            
            if(pain >= 9) {
                if(!confirm('⚠️ PAIN LEVEL ' + pain + '/10! ⚠️\n\nAt this pain level, the only clicking you should do is speed-dial to 911.\n\nThis form cannot prescribe morphine or sympathy.\n\nStill want to continue this charade?')) {
                    e.preventDefault();
                }
            }
        });
        
        <?php if($triage): ?>
        setTimeout(() => {
            alert('ASSESSMENT COMPLETE!\n\nYou just got medical advice from a website that uses Comic Sans.\n\nLet that sink in.\n\nNow go see an actual healthcare professional.');
        }, 500);
        <?php endif; ?>
        
        // Disable right-click and copy
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        
        // Dramatic announcements
        setTimeout(() => {
            alert("💀 AM I DYING?! 💀\n\nWelcome to the most dramatic self-assessment tool on the internet!\n\nSpoiler Alert: You're probably fine.\n\nBut let's be dramatic about it anyway!");
        }, 2000);
        
        setInterval(() => {
            if(Math.random() < 0.12) {
                alert("⚠️ HEALTH TIP ⚠️\n\nIf you Google your symptoms, you'll always get cancer.\n\nMutual funds may vary, but Google diagnosis? Always cancer.\n\nSee a real doctor instead!");
            }
        }, 20000);
        
        // Make submit button dramatic
        const submitBtn = document.querySelector('button[type=\"submit\"]');
        let dramaBtnHover = 0;
        if(submitBtn) {
            submitBtn.addEventListener('mouseenter', function() {
                dramaBtnHover++;
                if(dramaBtnHover < 3) {
                    if(confirm("⚠️ WARNING ⚠️\n\nYou're about to find out if you're dying.\n\nAre you emotionally prepared for this?\n\n(It's always \"probably not\" but still)")) {
                        // Allow hover
                    } else {
                        this.style.position = 'fixed';
                        this.style.top = Math.random() * 70 + 'vh';
                        this.style.left = Math.random() * 70 + 'vw';
                    }
                }
            });
        }
    </script>
</body>
</html>
