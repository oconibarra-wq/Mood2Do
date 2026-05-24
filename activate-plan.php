<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("location: no-user-index.php");
    exit();
}

if (!isset($_SESSION['plan_result'])) {
    header("location: new-plan.php");
    exit();
}

$plans = [
    1 => [
        'name'       => 'Reset Plan',
        'emoji'      => '😌',
        'mood_label' => 'Reflective',
        'study_mode' => 'Soft Focus',
        'color_main' => '#f4845f',
        'activities' => [
            '5-minute nervous system reset',
            'Tea + comforting ritual',
            'Gentle walk',
            'Low-stimulation hobby',
            'No-decision meal',
            '"Reduce friction" to-do list',
        ],
    ],
    2 => [
        'name'       => 'Deep Focus Plan',
        'emoji'      => '🎯',
        'mood_label' => 'Focused',
        'study_mode' => 'Deep Focus',
        'color_main' => '#6366f1',
        'activities' => [
            '90-min Pomodoro block',
            'Distraction-free workspace setup',
            'Priority task list (top 3)',
            'Background lo-fi or silence',
            'Cold water + good lighting',
            'Review & reward after session',
        ],
    ],
    3 => [
        'name'       => 'Creative Spark',
        'emoji'      => '✨',
        'mood_label' => 'Curious',
        'study_mode' => 'Free Explore',
        'color_main' => '#f59e0b',
        'activities' => [
            'Mind-map or doodle session',
            'Read something outside your field',
            'Creative writing sprint (10 min)',
            'Explore a new playlist or podcast',
            'Sketch a crazy idea — no judgment',
            'End with a reflection note',
        ],
    ],
    4 => [
        'name'       => 'Social Flow',
        'emoji'      => '🤝',
        'mood_label' => 'Connected',
        'study_mode' => 'Collaborative',
        'color_main' => '#10b981',
        'activities' => [
            'Study with a friend or group',
            'Teach someone something you know',
            'Join an online study community',
            'Pair-work on a shared project',
            'Share your goals for today aloud',
            'Debrief & celebrate with others',
        ],
    ],
    5 => [
        'name'       => 'Momentum Builder',
        'emoji'      => '🚀',
        'mood_label' => 'Steady',
        'study_mode' => 'Gentle Progress',
        'color_main' => '#3b82f6',
        'activities' => [
            'Pick ONE small task to finish first',
            '25-min Pomodoro + 10-min break',
            'Tidy your workspace before starting',
            'Brain dump everything on your mind',
            'Celebrate each small win',
            "Plan tomorrow's first step tonight",
        ],
    ],
];

$plan_id = $_SESSION['plan_result'];
$plan    = $plans[$plan_id] ?? null;

if (!$plan) {
    header("location: new-plan.php");
    exit();
}

$_SESSION['active_plan'] = [
    'id'         => $plan_id,
    'name'       => $plan['name'],
    'emoji'      => $plan['emoji'],
    'mood_label' => $plan['mood_label'],
    'study_mode' => $plan['study_mode'],
    'color_main' => $plan['color_main'],
    'activities' => array_map(function($act) {
        return ['text' => $act, 'done' => false];
    }, $plan['activities']),
    'started_at' => date('Y-m-d H:i:s'),
];

header("location: user-index.php");
exit();