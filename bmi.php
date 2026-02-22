<?php
session_start();

if(!isset($_SESSION['USER_EMAIL'])) {
    header('Location: login.php');
    exit;
}

$bmi = null;
$category = '';
$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = floatval($_POST['weight'] ?? 0);
    $height = floatval($_POST['height'] ?? 0);
    
    if($weight > 0 && $height > 0) {
        $bmi = $weight / (($height / 100) * ($height / 100));
        
        if($bmi < 18.5) {
            $category = 'UNDERWEIGHT';
            $message = 'Your BMI indicates you may be underweight. Consider consulting a healthcare professional.';
        } elseif($bmi < 25) {
            $category = 'NORMAL';
            $message = 'Your BMI is within the normal range. Keep maintaining a healthy lifestyle!';
        } elseif($bmi < 30) {
            $category = 'OVERWEIGHT';
            $message = 'Your BMI indicates you may be overweight. Consider a balanced diet and regular exercise.';
        } else {
            $category = 'OBESE';
            $message = 'Your BMI indicates obesity. Please consult with a healthcare professional for guidance.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator - HealthMart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }
        
        body {
            background: repeating-linear-gradient(
                45deg,
                #ffff00,
                #ffff00 10px,
                #ff00ff 10px,
                #ff00ff 20px
            );
            font-family: 'Comic Sans MS', cursive;
            padding: 20px;
        }
        
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }
        
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
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
            padding: 30px;
            border: 10px solid #000;
            margin-bottom: 30px;
            animation: shake 2s infinite;
        }
        
        .header h1 {
            font-size: 48px;
            text-shadow: 3px 3px #000;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border: 15px double #ff00ff;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.5);
        }
        
        .warning {
            background: #ffff00;
            border: 5px solid #ff0000;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            animation: blink 2s infinite;
        }
        
        .form-group {
            margin-bottom: 30px;
            padding: 20px;
            border: 5px solid #00ff00;
            border-radius: 20px;
            background: #e6ffe6;
        }
        
        label {
            display: block;
            font-size: 24px;
            color: #ff0000;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 15px;
            font-size: 24px;
            border: 5px solid #ff00ff;
            border-radius: 15px;
            background: #ffffcc;
            font-family: 'Comic Sans MS', cursive;
        }
        
        .unit-label {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }
        
        .calculate-btn {
            width: 100%;
            padding: 30px;
            font-size: 36px;
            background: linear-gradient(45deg, #ff0000, #ff00ff, #0000ff);
            color: #fff;
            border: 10px solid #ffff00;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 3px 3px #000;
            animation: pulse 2s infinite;
            margin-top: 20px;
        }
        
        .calculate-btn:hover {
            animation: shake 0.3s infinite;
        }
        
        .result-container {
            margin-top: 30px;
            padding: 30px;
            border: 10px solid #ff0000;
            border-radius: 20px;
            background: #fff;
        }
        
        .bmi-value {
            font-size: 72px;
            color: #ff0000;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
            text-shadow: 3px 3px #00ff00;
            animation: pulse 1s infinite;
        }
        
        .bmi-category {
            font-size: 48px;
            text-align: center;
            font-weight: bold;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
        }
        
        .category-underweight {
            background: #87ceeb;
            color: #0000ff;
        }
        
        .category-normal {
            background: #00ff00;
            color: #006600;
        }
        
        .category-overweight {
            background: #ffa500;
            color: #fff;
        }
        
        .category-obese {
            background: #ff0000;
            color: #fff;
        }
        
        .bmi-message {
            font-size: 24px;
            text-align: center;
            padding: 20px;
            background: #ffff00;
            border: 5px solid #000;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .bmi-chart {
            margin-top: 30px;
            padding: 20px;
            background: #f0f0f0;
            border: 5px solid #000;
            border-radius: 15px;
        }
        
        .bmi-chart h3 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .chart-bar {
            height: 40px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            padding-left: 10px;
            font-weight: bold;
            border: 3px solid #000;
            border-radius: 5px;
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
    </style>
</head>
<body>
    <a href="index.php" class="nav-back">← BACK TO CHAOS</a>
    
    <div class="header">
        <h1>BMI CALCULATOR</h1>
        <p style="font-size: 20px;">Calculate Your Body Mass Index</p>
    </div>
    
    <marquee behavior="scroll" direction="left">
        BMI = Body Mass Index | Professional Health Assessment Tool
    </marquee>
    
    <div class="container">
        <div class="warning">
            DISCLAIMER: This calculator is for informational purposes. BMI doesn't account for muscle mass or bone density. Consult a healthcare professional for personalized advice.
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>YOUR WEIGHT:</label>
                <input type="number" name="weight" step="0.1" required placeholder="Enter weight...">
                <div class="unit-label">In kilograms (kg)</div>
            </div>
            
            <div class="form-group">
                <label>YOUR HEIGHT:</label>
                <input type="number" name="height" step="0.1" required placeholder="Enter height...">
                <div class="unit-label">In centimeters (cm)</div>
            </div>
            
            <button type="submit" class="calculate-btn">
                CALCULATE BMI
            </button>
        </form>
        
        <?php if($bmi !== null): ?>
        <div class="result-container">
            <h2 style="text-align: center; font-size: 36px; color: #ff0000;">YOUR RESULTS:</h2>
            
            <div class="bmi-value">
                <?php echo number_format($bmi, 1); ?>
            </div>
            
            <div class="bmi-category category-<?php echo strtolower($category); ?>">
                <?php echo $category; ?>
            </div>
            
            <div class="bmi-message">
                <?php echo $message; ?>
            </div>
            
            <div class="bmi-chart">
                <h3>BMI CATEGORIES</h3>
                <div class="chart-bar" style="background: #87ceeb;">
                    &lt; 18.5 = UNDERWEIGHT
                </div>
                <div class="chart-bar" style="background: #00ff00;">
                    18.5 - 24.9 = NORMAL
                </div>
                <div class="chart-bar" style="background: #ffa500; color: #fff;">
                    25 - 29.9 = OVERWEIGHT
                </div>
                <div class="chart-bar" style="background: #ff0000; color: #fff;">
                    30+ = OBESE
                </div>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #e6f2ff; border: 3px solid #0000ff; border-radius: 10px;">
                <p style="font-size: 16px;"><strong>Fun Fact:</strong> BMI was invented in the 1830s by a mathematician (not a doctor!) and doesn't account for individual body composition. You're more than just a number! 💪</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <marquee behavior="scroll" direction="right">
        REMINDER: Health is more than just BMI - Eat well, exercise regularly, and maintain overall wellness
    </marquee>
    
    <script>
        // Annoying popup
        <?php if($bmi !== null): ?>
        setTimeout(() => {
            alert('BMI CALCULATION COMPLETE\n\nNumbers don\'t define you... but your insurance company disagrees.\n\nSeriously though: BMI is just one metric. Talk to a real doctor for actual health advice.');
        }, 1000);
        <?php endif; ?>
        
        // Random health tips
        const tips = [
            "Drink water regularly",
            "Exercise consistently",
            "Eat balanced meals",
            "Get adequate sleep",
            "Stay positive"
        ];
        
        setInterval(() => {
            if(Math.random() > 0.8) {
                const tip = tips[Math.floor(Math.random() * tips.length)];
                console.log("Health Tip: " + tip);
            }
        }, 5000);
        
        // Disable right-click and copy
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        
        // Annoying alerts
        setTimeout(() => {
            if(confirm("📊 BMI CALCULATOR TIPS 📊\n\nDid you know BMI doesn't account for:\n- Muscle mass\n- Bone density\n- Overall composition\n\nSo basically, The Rock is 'obese' by BMI.\n\nWant to calculate anyway?")) {
                setTimeout(() => {
                    alert("💡 PRO TIP 💡\n\nIf you don't like your BMI results, just:\n- Stand on one foot\n- Hold your breath\n- Believe in yourself\n\n(Or talk to an actual doctor)");
                }, 5000);
            }
        }, 2000);
        
        // Random calculations that are wrong
        setInterval(() => {
            if(Math.random() < 0.1) {
                alert("⚠️ SYSTEM UPDATE ⚠️\n\nRecalculating your BMI...\n\nJust kidding! We got it right the first time.\n\n(Probably)");
            }
        }, 15000);
        
        // Make submit button move
        const calcBtn = document.querySelector('.calculate-btn');
        let btnHoverCount = 0;
        if(calcBtn) {
            calcBtn.addEventListener('mouseenter', function() {
                btnHoverCount++;
                if(btnHoverCount < 3) {
                    this.style.position = 'fixed';
                    this.style.top = Math.random() * 70 + 'vh';
                    this.style.left = Math.random() * 70 + 'vw';
                    this.style.zIndex = '9999';
                } else {
                    this.style.position = 'relative';
                    this.textContent = '✅ CALCULATE IT ALREADY!';
                }
            });
        }
    </script>
</body>
</html>
