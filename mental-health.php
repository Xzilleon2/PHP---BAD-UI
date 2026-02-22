<?php
session_start();

if(!isset($_SESSION['USER_EMAIL'])) {
    header('Location: login.php');
    exit;
}

$dailyTips = [
    "Drink water - Stay hydrated throughout the day.",
    "Practice mindfulness - Take 5 deep breaths when feeling stressed.",
    "Take regular breaks - Step away from screens every hour.",
    "Go for a walk - Physical activity improves mental wellbeing.",
    "Practice gratitude - Write down 3 things you're grateful for.",
    "Listen to music - It can positively affect your mood.",
    "Get sunlight - Natural light helps regulate your circadian rhythm.",
    "Prioritize sleep - Aim for 7-9 hours per night.",
    "Connect with others - Social interaction is vital for mental health.",
    "Read for pleasure - It can reduce stress and improve focus.",
    "Be creative - Engage in activities that bring you joy.",
    "Set boundaries - It's okay to say no and prioritize your wellbeing.",
];

$randomTip = $dailyTips[array_rand($dailyTips)];

$mood = '';
$response = '';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mood'])) {
    $mood = $_POST['mood'];
    
    switch($mood) {
        case 'great':
            $response = "AMAZING! Keep that positive energy going! Share some of that joy with the world!";
            break;
        case 'good':
            $response = "That's wonderful! A good day is worth celebrating. Keep taking care of yourself!";
            break;
        case 'okay':
            $response = "Okay is okay! Not every day needs to be perfect. You're doing fine!";
            break;
        case 'bad':
            $response = "Sorry you're having a rough day. Remember, bad days don't last forever. Be kind to yourself!";
            break;
        case 'terrible':
            $response = "That sounds really tough. Please remember you're not alone. Consider talking to someone you trust, or reach out to a mental health professional. You deserve support!<br><br><strong>Crisis Resources:</strong><br>• National Suicide Prevention Lifeline: 988<br>• Crisis Text Line: Text HOME to 741741";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Corner - Professional Care</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Comic Sans MS', cursive;
            padding: 20px;
            min-height: 100vh;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border: 10px solid #ff00ff;
            margin-bottom: 30px;
            border-radius: 30px;
            animation: float 3s ease-in-out infinite;
        }
        
        .header h1 {
            font-size: 48px;
            color: #764ba2;
            text-shadow: 3px 3px #ffff00;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .tip-of-the-day {
            background: #ffff00;
            border: 10px double #ff0000;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: 20px;
            text-align: center;
            animation: pulse 2s infinite;
        }
        
        .tip-of-the-day h2 {
            font-size: 32px;
            color: #ff0000;
            margin-bottom: 20px;
        }
        
        .tip-of-the-day p {
            font-size: 24px;
            color: #000;
        }
        
        .mood-tracker {
            background: rgba(255, 255, 255, 0.95);
            border: 8px solid #00ff00;
            padding: 40px;
            margin-bottom: 30px;
            border-radius: 25px;
        }
        
        .mood-tracker h2 {
            font-size: 36px;
            color: #764ba2;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .mood-buttons {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin: 30px 0;
        }
        
        .mood-btn {
            padding: 20px;
            font-size: 24px;
            border: 5px solid;
            border-radius: 20px;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s;
            background: #fff;
        }
        
        .mood-btn:hover {
            transform: scale(1.1);
        }
        
        .mood-great {
            border-color: #00ff00;
        }
        
        .mood-great:hover {
            background: #ccffcc;
        }
        
        .mood-good {
            border-color: #90ee90;
        }
        
        .mood-good:hover {
            background: #e6ffe6;
        }
        
        .mood-okay {
            border-color: #ffff00;
        }
        
        .mood-okay:hover {
            background: #ffffcc;
        }
        
        .mood-bad {
            border-color: #ffa500;
        }
        
        .mood-bad:hover {
            background: #ffe6cc;
        }
        
        .mood-terrible {
            border-color: #ff0000;
        }
        
        .mood-terrible:hover {
            background: #ffcccc;
        }
        
        .mood-response {
            margin-top: 30px;
            padding: 30px;
            border: 5px solid #764ba2;
            border-radius: 15px;
            background: #f0e6ff;
            text-align: center;
            font-size: 20px;
            animation: fadeIn 0.5s;
        }
        
        .wellness-activities {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .activity-card {
            background: rgba(255, 255, 255, 0.95);
            border: 6px solid;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s;
        }
        
        .activity-card:hover {
            transform: rotate(2deg) scale(1.05);
        }
        
        .activity-card h3 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .activity-card p {
            font-size: 16px;
            line-height: 1.6;
        }
        
        .activity-card:nth-child(1) {
            border-color: #ff6b6b;
        }
        
        .activity-card:nth-child(2) {
            border-color: #4ecdc4;
        }
        
        .activity-card:nth-child(3) {
            border-color: #45b7d1;
        }
        
        .activity-card:nth-child(4) {
            border-color: #f7dc6f;
        }
        
        .activity-card:nth-child(5) {
            border-color: #bb8fce;
        }
        
        .activity-card:nth-child(6) {
            border-color: #85c1e2;
        }
        
        .resources {
            background: rgba(255, 255, 255, 0.95);
            border: 8px solid #ff0000;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
        }
        
        .resources h2 {
            font-size: 32px;
            color: #ff0000;
            margin-bottom: 20px;
        }
        
        .resources ul {
            list-style: none;
            padding: 0;
        }
        
        .resources li {
            padding: 15px;
            margin: 10px 0;
            background: #e6f2ff;
            border: 3px solid #0000ff;
            border-radius: 10px;
            font-size: 18px;
        }
        
        .positive-message {
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            border: 10px solid #ffff00;
            padding: 40px;
            border-radius: 30px;
            text-align: center;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            text-shadow: 3px 3px #000;
            animation: pulse 3s infinite;
        }
        
        marquee {
            background: #00ff00;
            color: #ff0000;
            padding: 15px;
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
        <h1>Mental Health Corner</h1>
        <p style="font-size: 20px; color: #764ba2; margin-top: 10px;">
            Professional Mental Wellness Support
        </p>
    </div>
    
    <marquee behavior="scroll" direction="left">
        Your mental health is important - Take care of yourself
    </marquee>
    
    <div class="container">
        <!-- Daily Tip -->
        <div class="tip-of-the-day">
            <h2>Daily Wellness Tip</h2>
            <p><?php echo $randomTip; ?></p>
        </div>
        
        <!-- Mood Tracker -->
        <div class="mood-tracker">
            <h2>How Are You Feeling Today?</h2>
            <p style="text-align: center; font-size: 18px; margin-bottom: 20px;">
                Select the mood that best describes how you're feeling right now:
            </p>
            
            <form method="POST">
                <div class="mood-buttons">
                    <button type="submit" name="mood" value="great" class="mood-btn mood-great">
                        GREAT
                    </button>
                    <button type="submit" name="mood" value="good" class="mood-btn mood-good">
                        Good
                    </button>
                    <button type="submit" name="mood" value="okay" class="mood-btn mood-okay">
                        Okay
                    </button>
                    <button type="submit" name="mood" value="bad" class="mood-btn mood-bad">
                        Bad
                    </button>
                    <button type="submit" name="mood" value="terrible" class="mood-btn mood-terrible">
                        Terrible
                    </button>
                </div>
            </form>
            
            <?php if($response): ?>
            <div class="mood-response">
                <?php echo $response; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Wellness Activities -->
        <h2 style="text-align: center; font-size: 36px; color: #fff; margin: 30px 0; text-shadow: 3px 3px #000;">
            Self-Care Activities
        </h2>
        
        <div class="wellness-activities">
            <div class="activity-card">
                <h3>Breathing Exercise</h3>
                <p>Inhale for 4 counts, hold for 4, exhale for 4. Repeat 5 times. Your nervous system will thank you!</p>
            </div>
            
            <div class="activity-card">
                <h3>Journaling</h3>
                <p>Write down your thoughts. No grammar rules, no judgment. Just you and the paper (or screen).</p>
            </div>
            
            <div class="activity-card">
                <h3>Music Therapy</h3>
                <p>Put on your favorite playlist. Dance, sing, or just listen. Music is medicine!</p>
            </div>
            
            <div class="activity-card">
                <h3>Nature Walk</h3>
                <p>Step outside. Touch grass (literally). Notice the sky, the trees, the birds. Nature heals.</p>
            </div>
            
            <div class="activity-card">
                <h3>Connect With Others</h3>
                <p>Call a friend, hug a family member, pet a dog. Social connection is vital for mental health!</p>
            </div>
            
            <div class="activity-card">
                <h3>Self-Pampering</h3>
                <p>Take a relaxing bath, do a face mask, or just sit in comfy pajamas. You deserve it!</p>
            </div>
        </div>
        
        <!-- Crisis Resources -->
        <div class="resources">
            <h2>Mental Health Resources</h2>
            <p style="margin-bottom: 20px; font-size: 16px;">
                If you're struggling with your mental health, please know that help is available. You don't have to face this alone.
            </p>
            
            <ul>
                <li>
                    <strong>988 Suicide & Crisis Lifeline:</strong> Call or text 988<br>
                    <small>24/7, free and confidential support</small>
                </li>
                <li>
                    <strong>Crisis Text Line:</strong> Text HOME to 741741<br>
                    <small>Free, 24/7 crisis support via text</small>
                </li>
                <li>
                    <strong>SAMHSA National Helpline:</strong> 1-800-662-4357<br>
                    <small>Substance abuse and mental health services</small>
                </li>
                <li>
                    <strong>NAMI Helpline:</strong> 1-800-950-6264<br>
                    <small>Mental health information and support</small>
                </li>
                <li>
                    <strong>BetterHelp / TalkSpace:</strong> Online therapy platforms<br>
                    <small>Professional counseling from home</small>
                </li>
                <li>
                    <strong>Local Resources:</strong> Search "mental health services near me"<br>
                    <small>Find therapists, counselors, and support groups in your area</small>
                </li>
            </ul>
        </div>
        
        <!-- Positive Message -->
        <div class="positive-message">
            YOU ARE IMPORTANT<br><br>
            Your feelings are valid.<br>
            Your struggles are real.<br>
            You deserve support and kindness.<br>
            It's okay to not be okay.<br>
            You are not alone.<br><br>
            KEEP GOING
        </div>
    </div>
    
    <marquee behavior="scroll" direction="right">
        REMEMBER: Bad days don't last forever - You've survived 100% of your worst days
    </marquee>
    
    <script>
        // Gentle encouragement popup
        <?php if($mood): ?>
        setTimeout(() => {
            alert('MOOD LOGGED\n\nYou\'re taking time to check in with yourself. That\'s more self-awareness than most people scrolling social media at 2 AM.\n\nSeriously though: Your mental health matters. Keep checking in, and reach out if you need support.');
        }, 500);
        <?php endif; ?>
        
        // Random positive affirmations in console
        const affirmations = [
            "You are enough!",
            "You are capable!",
            "You are strong!",
            "You are worthy of love!",
            "You are making progress!",
            "You are doing your best!"
        ];
        
        setInterval(() => {
            if(Math.random() > 0.7) {
                const affirmation = affirmations[Math.floor(Math.random() * affirmations.length)];
                console.log(affirmation);
            }
        }, 10000);
        
        // Disable right-click
        document.addEventListener('contextmenu', e => e.preventDefault());
        
        // Random mood check-ins
        setInterval(() => {
            if(Math.random() < 0.1) {
                alert("💭 MOOD CHECK-IN 💭\n\nHow are you feeling right now?\n\nNo seriously, take a moment.\n\nDeep breath.\n\nYou got this.");
            }
        }, 25000);
        
        // Annoying positivity
        setTimeout(() => {
            alert("🌟 REMINDER 🌟\n\nYou're visiting a mental health page.\n\nThat means you care about your wellbeing.\n\nThat's actually pretty awesome.\n\nKeep it up!");
        }, 3000);
    </script>
</body>
</html>
