#!/bin/bash

echo "📧 Setup Email Cepat untuk Forgot Password"
echo "=========================================="
echo ""

# Backup .env
cp .env .env.backup
echo "✅ Backup .env dibuat"

echo ""
echo "Pilih opsi:"
echo "1. Setup Gmail (perlu App Password)"
echo "2. Setup Mailtrap (testing email)"
echo "3. Kembali ke Log mode"
echo ""

read -p "Pilihan (1-3): " choice

case $choice in
    1)
        echo ""
        echo "📧 GMAIL SETUP"
        echo "=============="
        echo ""
        echo "LANGKAH-LANGKAH:"
        echo "1. Buka Gmail → Account → Security"
        echo "2. Aktifkan 2-Step Verification"
        echo "3. Buat App Password untuk Mail"
        echo "4. Copy password 16 karakter"
        echo ""
        
        read -p "Email Gmail Anda: " gmail
        echo "App Password (16 karakter, contoh: abcd efgh ijkl mnop):"
        read -p "App Password: " password
        
        # Update .env untuk Gmail
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
        sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=smtp.gmail.com/' .env
        sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=587/' .env
        sed -i '' "s/MAIL_USERNAME=.*/MAIL_USERNAME=$gmail/" .env
        sed -i '' "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$password/" .env
        sed -i '' "s/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=\"$gmail\"/" .env
        sed -i '' 's/MAIL_FROM_NAME=.*/MAIL_FROM_NAME="RS Dolopo"/' .env
        
        # Add encryption
        if ! grep -q "MAIL_ENCRYPTION" .env; then
            echo "MAIL_ENCRYPTION=tls" >> .env
        else
            sed -i '' 's/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/' .env
        fi
        
        echo ""
        echo "✅ Gmail SMTP dikonfigurasi!"
        ;;
        
    2)
        echo ""
        echo "📧 MAILTRAP SETUP"
        echo "================"
        echo ""
        echo "1. Daftar gratis di: https://mailtrap.io"
        echo "2. Buat inbox baru"
        echo "3. Copy SMTP credentials"
        echo ""
        
        read -p "Mailtrap Username: " mt_user
        read -p "Mailtrap Password: " mt_pass
        
        # Update .env untuk Mailtrap
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=smtp/' .env
        sed -i '' 's/MAIL_HOST=.*/MAIL_HOST=sandbox.smtp.mailtrap.io/' .env
        sed -i '' 's/MAIL_PORT=.*/MAIL_PORT=2525/' .env
        sed -i '' "s/MAIL_USERNAME=.*/MAIL_USERNAME=$mt_user/" .env
        sed -i '' "s/MAIL_PASSWORD=.*/MAIL_PASSWORD=$mt_pass/" .env
        sed -i '' 's/MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS="noreply@rsdolopo.test"/' .env
        sed -i '' 's/MAIL_FROM_NAME=.*/MAIL_FROM_NAME="RS Dolopo"/' .env
        
        if ! grep -q "MAIL_ENCRYPTION" .env; then
            echo "MAIL_ENCRYPTION=tls" >> .env
        else
            sed -i '' 's/MAIL_ENCRYPTION=.*/MAIL_ENCRYPTION=tls/' .env
        fi
        
        echo ""
        echo "✅ Mailtrap dikonfigurasi!"
        echo "📧 Email akan muncul di inbox Mailtrap Anda"
        ;;
        
    3)
        # Back to log mode
        sed -i '' 's/MAIL_MAILER=.*/MAIL_MAILER=log/' .env
        echo "✅ Kembali ke log mode"
        echo "📁 Email disimpan di: storage/logs/laravel.log"
        ;;
        
    *)
        echo "❌ Pilihan tidak valid"
        exit 1
        ;;
esac

echo ""
echo "🔄 Membersihkan cache..."
php artisan config:clear
php artisan cache:clear

echo ""
echo "🎉 Setup selesai!"
echo ""
echo "📝 Test forgot password di: http://localhost:8000/forgot-password"
echo "💾 Backup .env tersimpan di: .env.backup"
echo ""