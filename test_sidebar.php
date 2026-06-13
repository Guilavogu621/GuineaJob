<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('role', 'employeur')->first();
Auth::login($user);

$html = view('employer.dashboard', ['user' => $user, 'totalEmployees' => 0, 'newHires' => 0, 'openPositions' => 0, 'attendanceRate' => 0, 'congesEnAttente' => 0, 'recentApplicationsCount' => 0, 'headcountTrend' => [], 'headcountMonths' => [], 'deptSeries' => [], 'deptLabels' => [], 'recentActivities' => [], 'upcomingEvents' => []])->render();

$doc = new DOMDocument();
@$doc->loadHTML($html);
$xpath = new DOMXPath($doc);
$aside = $xpath->query("//aside");

if ($aside->length > 0) {
    echo "Aside found! Classes: " . $aside->item(0)->getAttribute('class') . "\n";
    echo "Aside inner HTML length: " . strlen($aside->item(0)->nodeValue) . "\n";
    if (strlen($aside->item(0)->nodeValue) < 100) {
        echo "Aside content is too small!\n";
    }
} else {
    echo "No aside found!\n";
}
