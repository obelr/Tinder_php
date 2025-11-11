#!/bin/bash

# Quick Deployment Script for HyperSwipe
# This script helps you deploy backend and frontend quickly

set -e

echo "🚀 HyperSwipe Deployment Script"
echo "================================"
echo ""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Step 1: Check if backend URL is provided
if [ -z "$1" ]; then
    echo -e "${YELLOW}Usage: ./deploy.sh <BACKEND_URL>${NC}"
    echo "Example: ./deploy.sh https://hyperswipe-backend.onrender.com"
    exit 1
fi

BACKEND_URL=$1
API_URL="${BACKEND_URL}/api"

echo -e "${GREEN}✓ Backend URL: ${BACKEND_URL}${NC}"
echo -e "${GREEN}✓ API URL: ${API_URL}${NC}"
echo ""

# Step 2: Update frontend .env
echo "📝 Updating frontend environment variables..."
cd tinder-clone
echo "EXPO_PUBLIC_API_URL=${API_URL}" > .env
echo -e "${GREEN}✓ Updated tinder-clone/.env${NC}"
echo ""

# Step 3: Build for web
echo "🌐 Building web version..."
npx expo export:web
echo -e "${GREEN}✓ Web build complete${NC}"
echo ""

# Step 4: Deploy to Vercel (if vercel CLI is installed)
if command -v vercel &> /dev/null; then
    echo "🚀 Deploying to Vercel..."
    vercel --prod --yes
    echo -e "${GREEN}✓ Deployed to Vercel${NC}"
else
    echo -e "${YELLOW}⚠ Vercel CLI not found. Install with: npm install -g vercel${NC}"
    echo "   Then run: cd tinder-clone && vercel --prod"
fi

echo ""
echo -e "${GREEN}✅ Deployment complete!${NC}"
echo ""
echo "📱 Next steps:"
echo "   1. Share your Vercel URL with recruiters"
echo "   2. Or create mobile build: cd tinder-clone && eas build --platform android --profile preview"
echo ""

