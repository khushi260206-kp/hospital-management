#!/bin/bash
echo "=== Hospital Management System - Database Setup ==="
echo ""
echo "This script will help you set up the database."
echo ""

# Prompt for MySQL password
read -sp "Enter MySQL root password (press Enter if no password): " MYSQL_PASSWORD
echo ""

# Update .env file with password
if [ -f .env ]; then
    if [ -z "$MYSQL_PASSWORD" ]; then
        sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=/' .env
    else
        sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$MYSQL_PASSWORD/" .env
    fi
    echo "✓ Updated .env file with database password"
else
    echo "✗ .env file not found!"
    exit 1
fi

# Try to create database
echo ""
echo "Attempting to create database..."
if [ -z "$MYSQL_PASSWORD" ]; then
    mysql -u root -e "CREATE DATABASE IF NOT EXISTS hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>&1
else
    mysql -u root -p"$MYSQL_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>&1
fi

if [ $? -eq 0 ]; then
    echo "✓ Database created successfully"
    echo ""
    echo "Now run: php artisan migrate"
else
    echo "✗ Failed to create database. Please check your MySQL credentials."
    echo ""
    echo "You can manually create the database by running:"
    if [ -z "$MYSQL_PASSWORD" ]; then
        echo "  mysql -u root -e \"CREATE DATABASE hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\""
    else
        echo "  mysql -u root -p -e \"CREATE DATABASE hospital_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\""
    fi
fi
