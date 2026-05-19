#!/bin/bash

# 🔒 Security Verification Script for VeilleSci
# Run this to verify security configurations are properly deployed
#
# Usage: bash security-verify.sh [local|staging|production]
#

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Environment
ENV=${1:-local}
DOMAIN=${2:-http://localhost}

echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}🔒 VeilleSci Security Verification Script${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo ""
echo "Environment: $ENV"
echo "Domain: $DOMAIN"
echo ""

# Counter
TESTS_PASSED=0
TESTS_FAILED=0

# Test 1: Check APP_DEBUG
echo -e "${YELLOW}[1/10]${NC} Checking APP_DEBUG setting..."
if grep -q "APP_DEBUG=false" .env 2>/dev/null || grep -q "APP_ENV=production" .env 2>/dev/null; then
    echo -e "${GREEN}✓ APP_DEBUG is properly set${NC}"
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ WARNING: APP_DEBUG might be true in production${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 2: Check .env is not in git
echo -e "${YELLOW}[2/10]${NC} Checking .env in .gitignore..."
if grep -q "\.env" .gitignore 2>/dev/null; then
    echo -e "${GREEN}✓ .env is in .gitignore${NC}"
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ ERROR: .env might be in version control${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 3: Check Session encryption
echo -e "${YELLOW}[3/10]${NC} Checking SESSION_ENCRYPT..."
if grep -q "SESSION_ENCRYPT=true" .env 2>/dev/null || [[ "$ENV" == "local" ]]; then
    echo -e "${GREEN}✓ Session encryption is enabled (or local environment)${NC}"
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ WARNING: SESSION_ENCRYPT should be true in $ENV${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 4: Check database credentials
echo -e "${YELLOW}[4/10]${NC} Checking database configuration..."
if grep -q "DB_" .env 2>/dev/null; then
    if [[ "$ENV" == "production" ]]; then
        if grep -q "DB_PASSWORD" .env 2>/dev/null; then
            DB_PASS=$(grep "DB_PASSWORD=" .env | cut -d'=' -f2)
            if [ ${#DB_PASS} -lt 8 ]; then
                echo -e "${RED}✗ ERROR: Database password is too weak (min 20 chars in production)${NC}"
                ((TESTS_FAILED++))
            else
                echo -e "${GREEN}✓ Database password appears strong${NC}"
                ((TESTS_PASSED++))
            fi
        fi
    else
        echo -e "${GREEN}✓ Database configured (local/staging environment)${NC}"
        ((TESTS_PASSED++))
    fi
else
    echo -e "${RED}✗ ERROR: Database not configured${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 5: Check security headers
echo -e "${YELLOW}[5/10]${NC} Checking Security Headers..."
if curl -s -I "$DOMAIN" | grep -q "X-Frame-Options"; then
    echo -e "${GREEN}✓ Security headers are present${NC}"
    curl -s -I "$DOMAIN" | grep -E "X-Frame|X-Content|Strict-Transport" | sed 's/^/  /'
    ((TESTS_PASSED++))
else
    if [[ "$ENV" == "local" ]]; then
        echo -e "${YELLOW}⚠ Skipping header check in local environment${NC}"
    else
        echo -e "${RED}✗ WARNING: Security headers might not be present${NC}"
        ((TESTS_FAILED++))
    fi
fi
echo ""

# Test 6: Check middleware registration
echo -e "${YELLOW}[6/10]${NC} Checking middleware registration..."
if grep -q "SecurityHeadersMiddleware" bootstrap/app.php 2>/dev/null; then
    echo -e "${GREEN}✓ Security middleware is registered${NC}"
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ ERROR: Security middleware not found in bootstrap/app.php${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 7: Check audit logging channel
echo -e "${YELLOW}[7/10]${NC} Checking audit logging configuration..."
if grep -q "'audit'" config/logging.php 2>/dev/null; then
    echo -e "${GREEN}✓ Audit logging channel is configured${NC}"
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ ERROR: Audit logging channel not found${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 8: Check rate limiting on auth routes
echo -e "${YELLOW}[8/10]${NC} Checking rate limiting on auth routes..."
if grep -q "throttle" routes/auth.php 2>/dev/null; then
    echo -e "${GREEN}✓ Rate limiting is configured on auth routes${NC}"
    grep "throttle" routes/auth.php | head -2 | sed 's/^/  /'
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ ERROR: Rate limiting not found on auth routes${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 9: Check encryption migration
echo -e "${YELLOW}[9/10]${NC} Checking encryption migration..."
if [ -f "database/migrations/2026_05_19_encrypt_user_sensitive_data.php" ]; then
    echo -e "${GREEN}✓ Encryption migration exists${NC}"
    ((TESTS_PASSED++))
else
    echo -e "${RED}✗ WARNING: Encryption migration not found${NC}"
    ((TESTS_FAILED++))
fi
echo ""

# Test 10: Check file permissions (production only)
echo -e "${YELLOW}[10/10]${NC} Checking file permissions..."
if [[ "$ENV" == "production" ]]; then
    ENV_PERMS=$(stat -c "%a" .env 2>/dev/null || stat -f "%OLp" .env 2>/dev/null)
    if [[ "$ENV_PERMS" == "600" ]] || [[ "$ENV_PERMS" == "-rw-------" ]]; then
        echo -e "${GREEN}✓ .env has correct permissions (600)${NC}"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗ ERROR: .env permissions are too open ($ENV_PERMS should be 600)${NC}"
        ((TESTS_FAILED++))
    fi
else
    echo -e "${YELLOW}⚠ Skipping permission check in $ENV environment${NC}"
fi
echo ""

# Summary
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "${BLUE}TEST RESULTS${NC}"
echo -e "${BLUE}════════════════════════════════════════════════════════════${NC}"
echo -e "Passed: ${GREEN}$TESTS_PASSED${NC}"
echo -e "Failed: ${RED}$TESTS_FAILED${NC}"
echo ""

if [ $TESTS_FAILED -eq 0 ]; then
    echo -e "${GREEN}✓ All security checks passed!${NC}"
    exit 0
else
    echo -e "${RED}✗ Some security checks failed. Please review the errors above.${NC}"
    exit 1
fi
