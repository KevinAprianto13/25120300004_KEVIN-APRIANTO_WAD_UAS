#!/bin/bash
# Script deploy GudangKu ke VPS dengan Docker
# Jalankan di server VPS sebagai root

set -e

echo "=== GudangKu Deploy Script ==="
echo "Tanggal: $(date)"
echo ""

# 1. Install Docker jika belum ada
if ! command -v docker &> /dev/null; then
    echo "[1/8] Installing Docker..."
    curl -fsSL https://get.docker.com | sh
    systemctl enable docker
    systemctl start docker
else
    echo "[1/8] Docker sudah terinstall: $(docker --version)"
fi

# 2. Install Docker Compose jika belum ada
if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null 2>&1; then
    echo "[2/8] Installing Docker Compose..."
    curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
else
    echo "[2/8] Docker Compose sudah terinstall"
fi

# 3. Clone repo
echo "[3/8] Cloning repository..."
if [ -d "/var/www/gudangku" ]; then
    echo "Direktori sudah ada, melakukan git pull..."
    cd /var/www/gudangku
    git pull origin main
else
    mkdir -p /var/www
    cd /var/www
    git clone https://github.com/KevinAprianto13/25120300004_KEVIN-APRIANTO_WAD_UAS.git gudangku
    cd gudangku
fi

# 4. Setup .env
echo "[4/8] Setup environment file..."
cp .env.production .env

# 5. Generate app key (akan dijalankan di container)
echo "[5/8] Setup selesai, siap build Docker..."

# 6. Build dan jalankan container
echo "[6/8] Building Docker containers..."
docker compose down --remove-orphans 2>/dev/null || true
docker compose build --no-cache
docker compose up -d

# 7. Tunggu MySQL ready
echo "[7/8] Menunggu MySQL siap..."
sleep 15

# 8. Setup Laravel di dalam container
echo "[8/8] Setup Laravel (key generate, migrate, seed)..."
docker compose exec -T app php artisan key:generate --force
docker compose exec -T app php artisan migrate:fresh --seed --force
docker compose exec -T app php artisan storage:link 2>/dev/null || true
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache

echo ""
echo "=== DEPLOY SELESAI! ==="
echo "Aplikasi berjalan di: http://103.247.10.44"
echo ""
echo "Login Admin : admin@gudangku.test | password123"
echo "Login Staff : staff@gudangku.test | password123"
echo ""
docker compose ps
