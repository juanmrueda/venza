#!/bin/bash
# =============================================================
# Venza — Deploy del tema al servidor
# Uso: bash deploy/deploy.sh
# Requiere: ~/.ssh/venza_deploy configurada
# =============================================================

SERVER="deploy@venza.ipalmera.com"
SSH_KEY="$HOME/.ssh/venza_deploy"
REMOTE_THEME="/var/www/html/wp-content/themes/venza"
BRANCH="main"

echo "🚀 Deploying Venza theme to $SERVER..."

# 1. Push local a GitHub primero
git push origin $BRANCH

# 2. SSH al servidor y pull del tema
ssh -i "$SSH_KEY" "$SERVER" bash << REMOTE
    set -e
    echo "📦 Pulling latest theme..."
    cd $REMOTE_THEME
    git pull origin $BRANCH
    echo "✅ Deploy completado."
    echo "   URL: https://venza.ipalmera.com"
REMOTE

echo ""
echo "✅ Deploy exitoso → https://venza.ipalmera.com"
