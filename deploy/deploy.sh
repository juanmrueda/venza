#!/bin/bash
# =============================================================
# Venza - Deploy del tema al servidor
# Uso: bash deploy/deploy.sh
# Requiere: ~/.ssh/venza_deploy configurada
# =============================================================

SERVER="root@142.93.15.66"
SSH_KEY="$HOME/.ssh/venza_deploy"
REMOTE_REPO="/var/repo/venza"
BRANCH="main"

echo "Deploying Venza theme to $SERVER..."

# 1. Push local a GitHub primero
git push origin $BRANCH

# 2. SSH al servidor y pull del repo con root
ssh -i "$SSH_KEY" "$SERVER" bash << REMOTE
    set -e
    echo "Pulling latest repo..."
    cd $REMOTE_REPO
    git pull origin $BRANCH
    echo "Deploy completado."
    echo "URL: https://venza.ipalmera.com"
REMOTE

echo ""
echo "Deploy exitoso -> https://venza.ipalmera.com"
