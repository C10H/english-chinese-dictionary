#!/bin/bash

# Build Docker image
echo "Building Docker image..."
docker build -t c10h15n/dictionary-app:latest .

# Test locally
echo "Running container locally on port 8080..."
docker run -d -p 8080:80 --name dictionary-test c10h15n/dictionary-app:latest

echo "Visit http://localhost:8080 to test the application"
echo "Admin login: http://localhost:8080/admin.php (admin/password)"

# Push to Docker Hub (run these commands after testing)
echo ""
echo "To push to Docker Hub, run:"
echo "docker login"
echo "docker push c10h15n/dictionary-app:latest"

# Cleanup test container
echo ""
echo "To cleanup test container:"
echo "docker stop dictionary-test && docker rm dictionary-test"