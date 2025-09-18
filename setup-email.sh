#!/bin/bash

echo "🚀 Email Configuration Setup untuk Laravel"
echo "========================================="
echo ""

# Backup .env file
cp .env .env.backup
echo "✅ Backup .env file dibuat (.env.backup)"

echo ""
echo "Pilih email service yang ingin digunakan:"
echo "1. Gmail (Gratis, mudah setup)"
echo "2. Mailtrap (Testing email)"
echo "3. SendGrid (Production, 100 email gratis/hari)"
echo "4. Custom SMTP"
echo "5. Kembali ke Log mode (development)"
echo ""

read -p "Masukkan pilihan (1-5): " choice

case $choice in
    1)
        echo ""
        echo "📧 Setup Gmail SMTP"
        echo "=================="
        echo ""
        echo "PENTING: Anda perlu membuat App Password di Gmail:"
        echo "1. Buka Google Account → Security"
        echo "2. Aktifkan 2-Step Verification"
        echo "3. Generate App Password untuk Mail"
        echo "4. Copy password 16 karakter yang digenerate"
        echo ""
        
        read -p "Gmail address: " gmail_address
        read -p "App Password (16 chars): " gmail_password
        read -p "Display name untuk email [RS Dolopo]: " display_name
        
        display_name=${display_name:-"RS Dolopo"}
        
        # Update .env file
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
        sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/' .env
        sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=587/' .env
        sed -i '' "s/MAIL_USERNAME=.*/MAIL_USERNAME=$gmail_address/" .env
        sed -i '' "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$gmail_password/" .env
        sed -i '' "s/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=\"$gmail_address\"/" .env
        sed -i '' "s/MAIL_FROM_NAME=.*/MAIL_FROM_NAME=\"$display_name\"/" .env
        
        # Add encryption if not exists
        if ! grep -q "MAIL_ENCRYPTION" .env; then
            echo "MAIL_ENCRYPTION=tls" >> .env
        else
            sed -i '' 's/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/' .env
        fi
        
        echo ""
        echo "✅ Gmail SMTP berhasil dikonfigurasi!"
        ;;
        
    2)
        echo ""
        echo "📧 Setup Mailtrap"
        echo "================"
        echo ""
        echo "Silakan daftar di https://mailtrap.io dan buat inbox"
        echo "Copy credentials dari inbox Settings → SMTP"
        echo ""
        
        read -p "Mailtrap Username: " mailtrap_user
        read -p "Mailtrap Password: " mailtrap_pass
        
        # Update .env file
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
        sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=sandbox.smtp.mailtrap.io/' .env
        sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=2525/' .env
        sed -i '' "s/MAIL_USERNAME=.*/MAIL_USERNAME=$mailtrap_user/" .env
        sed -i '' "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$mailtrap_pass/" .env
        sed -i '' 's/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS="noreply@rsdolopo.test"/' .env
        sed -i '' 's/MAIL_FROM_NAME=.*/MAIL_FROM_NAME="RS Dolopo"/' .env
        
        if ! grep -q "MAIL_ENCRYPTION" .env; then
            echo "MAIL_ENCRYPTION=tls" >> .env
        else
            sed -i '' 's/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/' .env
        fi
        
        echo ""
        echo "✅ Mailtrap berhasil dikonfigurasi!"
        echo "📧 Email akan muncul di inbox Mailtrap Anda"
        ;;
        
    3)
        echo ""
        echo "📧 Setup SendGrid"
        echo "================"
        echo ""
        echo "Silakan daftar di https://sendgrid.com"
        echo "Buat API Key di Settings → API Keys"
        echo ""
        
        read -p "SendGrid API Key: " sendgrid_key
        read -p "From Email Address: " from_email
        
        # Update .env file
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
        sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=smtp.sendgrid.net/' .env
        sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=587/' .env
        sed -i '' 's/MAIL_USERNAME=.*/MAIL_USERNAME=apikey/' .env
        sed -i '' "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$sendgrid_key/" .env
        sed -i '' "s/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=\"$from_email\"/" .env
        sed -i '' 's/MAIL_FROM_NAME=.*/MAIL_FROM_NAME="RS Dolopo"/' .env
        
        if ! grep -q "MAIL_ENCRYPTION" .env; then
            echo "MAIL_ENCRYPTION=tls" >> .env
        else
            sed -i '' 's/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/' .env
        fi
        
        echo ""
        echo "✅ SendGrid berhasil dikonfigurasi!"
        ;;
        
    4)
        echo ""
        echo "📧 Setup Custom SMTP"
        echo "==================="
        echo ""
        
        read -p "SMTP Host: " smtp_host
        read -p "SMTP Port [587]: " smtp_port
        read -p "Username: " smtp_user
        read -p "Password: " smtp_pass
        read -p "From Email: " from_email
        read -p "Encryption (tls/ssl/null) [tls]: " encryption
        
        smtp_port=${smtp_port:-587}
        encryption=${encryption:-tls}
        
        # Update .env file
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
        sed -i '' "s/MAIL_HOST=.*/MAIL_HOST=$smtp_host/" .env
        sed -i '' "s/MAIL_PORT=.*/MAIL_PORT=$smtp_port/" .env
        sed -i '' "s/MAIL_USERNAME=.*/MAIL_USERNAME=$smtp_user/" .env
        sed -i '' "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$smtp_pass/" .env
        sed -i '' "s/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=\"$from_email\"/" .env
        sed -i '' 's/MAIL_FROM_NAME=.*/MAIL_FROM_NAME="RS Dolopo"/' .env
        
        if ! grep -q "MAIL_ENCRYPTION" .env; then
            echo "MAIL_ENCRYPTION=$encryption" >> .env
        else
            sed -i '' "s/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=$encryption/" .env
        fi
        
        echo ""
        echo "✅ Custom SMTP berhasil dikonfigurasi!"
        ;;
        
    5)
        echo ""
        echo "📧 Kembali ke Log Mode"
        echo "====================="
        
        # Update .env file back to log
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=log/' .env
        sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=127.0.0.1/' .env
        sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=2525/' .env
        sed -i '' 's/MAIL_USERNAME=.*/MAIL_USERNAME=null/' .env
        sed -i '' 's/MAIL_PASSWORD=.*/MAIL_PASSWORD=null/' .env
        
        echo ""
        echo "✅ Email dikembalikan ke log mode (development)"
        echo "📁 Email akan disimpan di: storage/logs/laravel.log"
        ;;
        
    *)
        echo "❌ Pilihan tidak valid"
        exit 1
        ;;
esac

echo ""
echo "🔄 Membersihkan cache konfigurasi..."
php artisan config:clear
php artisan cache:clear

echo ""
echo "📧 Testing email configuration..."
echo ""

read -p "Kirim test email ke alamat: " test_email

# Create test email command
cat > test_email.php << 'EOL'
<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$testEmail = $argv[1] ?? 'test@example.com';

echo "Mengirim test email ke: $testEmail\n";

try {
    Mail::raw('Ini adalah test email dari sistem RS Dolopo. Jika Anda menerima email ini, berarti konfigurasi email sudah berhasil!', function ($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('Test Email - Sistem RS Dolopo');
    });
    
    echo "✅ Email berhasil dikirim!\n";
    echo "📧 Silakan periksa inbox email Anda\n";
} catch (Exception $e) {
    echo "❌ Error mengirim email: " . $e->getMessage() . "\n";
}
EOL

php test_email.php "$test_email"

# Cleanup
rm test_email.php

echo ""
echo "🎉 Setup email selesai!"
echo ""
echo "📝 Konfigurasi tersimpan di .env file"
echo "💾 Backup tersimpan di .env.backup"
echo ""
echo "🔗 Test forgot password di: http://localhost:8000/forgot-password"
echo ""