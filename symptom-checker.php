<?php
session_start();

if(!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

$diagnosis = '';
$severity = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symptoms = $_POST['symptoms'] ?? [];
    $symptomCount = count($symptoms);
    
    if($symptomCount === 0) {
        $diagnosis = "You have NO symptoms selected. If you're feeling well, that's great!";
        $severity = "healthy";
    } elseif($symptomCount <= 2) {
        $diagnosis = "Minor issues detected. Rest, stay hydrated, and monitor your symptoms.";
        $severity = "minor";
    } elseif($symptomCount <= 5) {
        $diagnosis = "Moderate concern. Consider consulting a healthcare provider if symptoms persist.";
        $severity = "moderate";
    } else {
        $diagnosis = "Multiple symptoms detected. Please consult a healthcare professional for proper evaluation.";
        $severity = "critical";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symptom Checker - HealthMart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }
        
        body {
            background: radial-gradient(circle, #ff0000, #00ff00, #0000ff);
            background-size: 200% 200%;
            animation: gradientMove 5s ease infinite;
            font-family: 'Comic Sans MS', cursive;
            padding: 20px;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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
            background: #ff00ff;
            color: #ffff00;
            padding: 30px;
            border: 10px solid #00ff00;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 48px;
            text-shadow: 3px 3px #000;
            animation: shake 1s infinite;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border: 15px double #ff0000;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 0 50px rgba(255, 0, 255, 0.8);
        }
        
        .warning {
            background: #ffff00;
            border: 5px solid #ff0000;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            animation: blink 2s infinite;
        }
        
        .symptom-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 30px 0;
        }
        
        .symptom-item {
            background: #e6e6ff;
            border: 5px solid #0000ff;
            border-radius: 15px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        
        .symptom-item:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .symptom-item input[type="checkbox"] {
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        
        .symptom-item label {
            font-size: 18px;
            margin-left: 10px;
            cursor: pointer;
            color: #000;
        }
        
        .symptom-item.checked {
            background: #ff6b6b;
            border-color: #ff0000;
            animation: shake 0.5s;
        }
        
        .submit-btn {
            width: 100%;
            padding: 30px;
            font-size: 36px;
            background: linear-gradient(45deg, #ff0000, #ff00ff);
            color: #fff;
            border: 10px solid #ffff00;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 3px 3px #000;
            margin-top: 20px;
        }
        
        .submit-btn:hover {
            animation: spin 1s linear;
        }
        
        .result-box {
            margin-top: 30px;
            padding: 30px;
            border: 10px solid;
            border-radius: 20px;
            text-align: center;
        }
        
        .result-healthy {
            background: #00ff00;
            border-color: #006600;
        }
        
        .result-minor {
            background: #ffff00;
            border-color: #ff8800;
        }
        
        .result-moderate {
            background: #ffa500;
            border-color: #ff0000;
        }
        
        .result-critical {
            background: #ff0000;
            border-color: #660000;
            color: #fff;
            animation: blink 1s infinite;
        }
        
        .result-box h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .result-box p {
            font-size: 24px;
        }
        
        .disclaimer {
            margin-top: 20px;
            padding: 15px;
            background: #f0f0f0;
            border: 3px dashed #000;
            border-radius: 10px;
            font-size: 14px;
        }
        
        marquee {
            background: #00ff00;
            color: #ff0000;
            padding: 10px;
            font-size: 20px;
            font-weight: bold;
            border: 5px solid #0000ff;
            margin: 20px 0;
        }
        
        .webmd-joke {
            background: #e6e6e6;
            border: 5px solid #ff0000;
            padding: 20px;
            margin: 20px 0;
            border-radius: 15px;
            text-align: center;
        }
        
        .webmd-joke h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <a href="index.php" class="nav-back">← BACK TO SAFETY</a>
    
    <div class="header">
        <h1>SYMPTOM CHECKER</h1>
        <p style="font-size: 20px;">Professional Symptom Assessment Tool</p>
    </div>
    
    <marquee behavior="scroll" direction="left">
        WARNING: This tool is for informational purposes only - For real medical advice, consult a healthcare professional
    </marquee>
    
    <div class="container">
        <div class="warning">
            DISCLAIMER: This is NOT real medical advice - For educational purposes only
        </div>
        
        <h2 style="text-align: center; font-size: 32px; color: #ff0000; margin-bottom: 20px;">
            SELECT YOUR SYMPTOMS:
        </h2>
        
        <p style="text-align: center; font-size: 18px; margin-bottom: 20px;">
            Check all that apply (or just click randomly for fun!)
        </p>
        
        <form method="POST" id="symptom-form">
            <div class="symptom-grid">
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="headache" id="s1">
                    <label for="s1">Headache</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="fever" id="s2">
                    <label for="s2">Fever</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="cough" id="s3">
                    <label for="s3">Cough</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="fatigue" id="s4">
                    <label for="s4">Fatigue</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="nausea" id="s5">
                    <label for="s5">Nausea</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="sore_throat" id="s6">
                    <label for="s6">Sore Throat</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="dizziness" id="s7">
                    <label for="s7">Dizziness</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="body_aches" id="s8">
                    <label for="s8">Body Aches</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="runny_nose" id="s9">
                    <label for="s9">Runny Nose</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="shortness_breath" id="s10">
                    <label for="s10">Shortness of Breath</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="loss_taste" id="s11">
                    <label for="s11">Loss of Taste</label>
                </div>
                
                <div class="symptom-item" onclick="toggleSymptom(this)">
                    <input type="checkbox" name="symptoms[]" value="anxiety" id="s12">
                    <label for="s12">Anxiety</label>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">
                ANALYZE SYMPTOMS
            </button>
        </form>
        
        <?php if($diagnosis): ?>
        <div class="result-box result-<?php echo $severity; ?>">
            <h2>ASSESSMENT RESULT</h2>
            <p><?php echo $diagnosis; ?></p>
            
            <div class="disclaimer">
                <p><strong>IMPORTANT:</strong> This is satire! If you're genuinely unwell, please consult a real healthcare professional. We're just a chaotic website making fun of WebMD! 😄</p>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="webmd-joke">
            <h3>Common Assessment Guide</h3>
            <p style="margin: 10px 0;">Headache = Monitor and rest</p>
            <p style="margin: 10px 0;">Cough = Stay hydrated</p>
            <p style="margin: 10px 0;">Tired = Get adequate sleep</p>
            <p style="margin: 10px 0;">Multiple symptoms = See a doctor</p>
            <p style="margin: 10px 0; font-weight: bold; color: #ff0000;">Severe symptoms = Seek immediate medical attention</p>
            <p style="margin-top: 15px; font-size: 12px; color: #666;">(This is a joke. WebMD is actually useful if you don't panic!)</p>
        </div>
    </div>
    
    <marquee behavior="scroll" direction="right">
        REMEMBER: Stay hydrated and get proper rest for minor ailments - Consult a doctor for persistent symptoms
    </marquee>
    
    <script>
        function toggleSymptom(element) {
            const checkbox = element.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            
            if(checkbox.checked) {
                element.classList.add('checked');
            } else {
                element.classList.remove('checked');
            }
        }
        
        // Prevent double-toggle when clicking checkbox directly
        document.querySelectorAll('.symptom-item input').forEach(input => {
            input.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
        
        // Add warning when selecting too many symptoms
        document.getElementById('symptom-form').addEventListener('submit', (e) => {
            const checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
            
            if(checked > 8) {
                if(!confirm('You selected ' + checked + ' symptoms.\n\nAccording to WebMD, you have everything from a cold to imminent demise.\n\nProceed with our slightly-less-dramatic analysis?')) {
                    e.preventDefault();
                }
            } else if(checked === 0) {
                alert('No symptoms selected.\n\nYou\'re either perfectly healthy or in denial.\n\nEither way, enjoy your functional existence!');
                e.preventDefault();
            }
        });
        
        <?php if($diagnosis): ?>
        setTimeout(() => {
            alert('ASSESSMENT COMPLETE\n\nOur advanced medical algorithm (random nonsense generator) has spoken.\n\nFor real medical advice: Close this tab and call an actual doctor.\n\nThey went to school for 8+ years for this.');
        }, 500);
        <?php endif; ?>
        
        // Disable right-click and copy-paste
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        
        // Random alerts
        setTimeout(() => {
            alert("⚠️ HEALTH DISCLAIMER ⚠️\n\nWARNING: Self-diagnosis is dangerous!\n\n...But also, we're going to let you do it anyway because this is a demo.\n\nIronic, isn't it?");
        }, 3000);
        
        setInterval(() => {
            if(Math.random() < 0.15) {
                const tips = [
                    "💡 TIP: Checking symptoms online will convince you you're dying. You're probably not.",
                    "💡 TIP: 99% of headaches are just headaches, not brain-eating amoebas.",
                    "💡 REMINDER: Your symptom checker results are as reliable as a Magic 8-Ball.",
                    "💡 FUN FACT: You probably just need water, sleep, or to stop doom-scrolling."
                ];
                alert(tips[Math.floor(Math.random() * tips.length)]);
            }
        }, 20000);
        
        // Make submit button move
        const submitBtn = document.querySelector('input[type="submit"]');
        let hoverCount = 0;
        if(submitBtn) {
            submitBtn.addEventListener('mouseenter', function() {
                hoverCount++;
                if(hoverCount < 3) {
                    this.style.position = 'fixed';
                    this.style.top = Math.random() * 70 + 'vh';
                    this.style.left = Math.random() * 70 + 'vw';
                    this.style.zIndex = '9999';
                } else {
                    this.style.position = 'relative';
                    this.value = '✅ OK FINE, SUBMIT!';
                }
            });
        }
    </script>
</body>
</html>
