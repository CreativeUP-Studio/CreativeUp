<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$s = App\Models\SiteSetting::first();
if (!$s) {
    $s = App\Models\SiteSetting::getDefault();
}
$s->footer_tagline = 'El amanecer de una imagen profesional';
$s->meta_description = 'CreativeUP - El amanecer de una imagen profesional';
$s->save();
echo "Updated SiteSettings slogan successfully!\n";
