#!/bin/bash
# =============================================================
# Genera la clave SSH dedicada para este proyecto
# Ejecutar UNA SOLA VEZ desde tu máquina local
# =============================================================

KEY="$HOME/.ssh/venza_deploy"

if [ -f "$KEY" ]; then
    echo "La clave ya existe: $KEY"
    echo "Clave pública:"
    cat "$KEY.pub"
    exit 0
fi

ssh-keygen -t ed25519 -C "venza-deploy@ipalmera.com" -f "$KEY" -N ""

echo ""
echo "============================================"
echo "  Clave SSH creada: $KEY"
echo ""
echo "  COPIA esta clave pública al servidor:"
echo "============================================"
cat "$KEY.pub"
echo ""
echo "  Agregar al servidor con:"
echo "  ssh-copy-id -i $KEY.pub root@IP_DEL_DROPLET"
echo ""
echo "  Luego configura ~/.ssh/config agregando:"
echo "  Host venza.ipalmera.com"
echo "    IdentityFile $KEY"
echo "    User deploy"
