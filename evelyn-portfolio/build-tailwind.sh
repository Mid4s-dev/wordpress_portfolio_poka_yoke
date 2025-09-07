#!/bin/bash

# Directory of the script
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "npm is not installed. Please install Node.js and npm first."
    exit 1
fi

# Go to theme directory
cd "$DIR"

# Install dependencies
npm install

# Build Tailwind CSS
npm run build

echo "Tailwind CSS built successfully!"
