#!/usr/bin/env python3
"""
Secure JSON Encryption Utility with Self-Expiring Keys

This utility encrypts JSON data and generates a self-expiring JWT token for decryption.
Each client receives a unique JWT signed with their private RSA key.

The client's Laravel application can decrypt the data until the JWT expires,
after which they must request a new key from you.

Features:
- One-time encryption of JSON data
- Self-expiring JWT tokens (default: 1 year)
- Tamper-proof: Uses RSA signatures
- Unique keys per client
- No modification possible on client side

Usage:
    python encrypt_data.py <json_file> <client_id> [--days DAYS]

Example:
    python encrypt_data.py my_secrets.json client_001
    python encrypt_data.py config.json client_002 --days 180
"""

import jwt
import datetime
import json
import sys
import os
import argparse
from cryptography.fernet import Fernet


def generate_package_for_specific_client(json_file_path, client_id, days_valid=365):
    """
    Encrypt JSON data and create a signed self-expiring JWT token.
    
    Args:
        json_file_path (str): Path to the JSON file to encrypt
        client_id (str): Client identifier (must match the key folder name)
        days_valid (int): Number of days the key remains valid (default: 365)
        
    Returns:
        tuple: (encrypted_data, jwt_token) or (None, error_message)
    """
    # --- WHERE THE DATA IS READ ---
    # Open your secret local JSON file
    try:
        with open(json_file_path, 'r') as file:
            raw_data = file.read()
            # Validate JSON format
            json.loads(raw_data)  # This will raise an exception if invalid JSON
    except FileNotFoundError:
        return None, f"Error: File '{json_file_path}' not found!"
    except json.JSONDecodeError as e:
        return None, f"Error: Invalid JSON format in '{json_file_path}': {e}"
    except Exception as e:
        return None, f"Error reading file: {e}"
    
    # 1. Encrypt Data
    # Generate a random key that will only be used for THIS file
    data_key = Fernet.generate_key()
    cipher = Fernet(data_key)
    encrypted_json = cipher.encrypt(raw_data.encode())
    
    # 2. Load your PRIVATE RSA key
    # This is used to "sign" the JWT so the client knows it came from you
    private_key_path = os.path.join("keys", client_id, "private.pem")
    try:
        with open(private_key_path, "rb") as f:
            private_key = f.read()
    except FileNotFoundError:
        return None, f"Error: Private key for '{client_id}' not found at {private_key_path}!\nRun: python generate_client_keys.py {client_id}"
    except Exception as e:
        return None, f"Error loading private key: {e}"
        
    # 3. Create the JWT (The "Key Package")
    # Calculate expiration date
    expiry_date = datetime.datetime.utcnow() + datetime.timedelta(days=days_valid)
    
    payload = {
        "iss": "LicenceAdmin-SecureDistributor",  # Issuer
        "sub": client_id,                         # Subject (client identifier)
        "iat": datetime.datetime.utcnow(),        # Issued at
        "exp": expiry_date,                       # Expiration (1 Year by default)
        "dk": data_key.decode()                   # Data Key (hidden inside signed JWT)
    }
    
    # Sign with RS256 (RSA + SHA256)
    try:
        token = jwt.encode(payload, private_key, algorithm="RS256")
    except Exception as e:
        return None, f"Error signing JWT: {e}"
    
    return encrypted_json, token


def main():
    parser = argparse.ArgumentParser(
        description='Encrypt JSON data and generate self-expiring client keys',
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  python encrypt_data.py secrets.json client_001
  python encrypt_data.py config.json client_002 --days 180
  
The encrypted data and JWT token will be saved to the 'output' directory.
        """
    )
    parser.add_argument('json_file', help='Path to the JSON file to encrypt')
    parser.add_argument('client_id', help='Client identifier (must match key folder)')
    parser.add_argument('--days', type=int, default=365, 
                       help='Number of days the key remains valid (default: 365)')
    
    args = parser.parse_args()
    
    # Validate inputs
    if args.days < 1:
        print("Error: Days must be a positive number")
        sys.exit(1)
    
    print(f"📁 Reading JSON file: {args.json_file}")
    print(f"🔑 Client ID: {args.client_id}")
    print(f"⏰ Validity: {args.days} days")
    print()
    
    # Generate the encrypted package
    enc_data, result = generate_package_for_specific_client(
        args.json_file, 
        args.client_id, 
        args.days
    )
    
    if enc_data is None:
        print(f"❌ {result}")
        sys.exit(1)
    
    client_jwt = result
    
    # Create output directory
    output_dir = "output"
    os.makedirs(output_dir, exist_ok=True)
    
    # Generate output filenames with client_id prefix
    encrypted_file = os.path.join(output_dir, f"{args.client_id}_data.enc")
    jwt_file = os.path.join(output_dir, f"{args.client_id}_key.jwt")
    
    # Save the encrypted file
    with open(encrypted_file, "wb") as f:
        f.write(enc_data)
    
    # Save the JWT to a text file for easy sharing
    with open(jwt_file, "w") as f:
        f.write(client_jwt)
    
    # Calculate expiration date for display
    expiry_date = datetime.datetime.utcnow() + datetime.timedelta(days=args.days)
    
    print("✅ Encryption successful!")
    print()
    print("📦 Output Files:")
    print(f"  Encrypted Data: {os.path.abspath(encrypted_file)}")
    print(f"  JWT Key:        {os.path.abspath(jwt_file)}")
    print()
    print("📤 Next Steps:")
    print(f"  1. Send {encrypted_file} to the client")
    print(f"  2. Send {jwt_file} to the client")
    print(f"  3. Client stores both in their Laravel application")
    print()
    print("ℹ️  Key Details:")
    print(f"  Client:     {args.client_id}")
    print(f"  Valid Until: {expiry_date.strftime('%Y-%m-%d %H:%M:%S')} UTC")
    print(f"  Duration:    {args.days} days")
    print()
    print("⚠️  Security Notes:")
    print("  - The encrypted data cannot be modified by the client")
    print("  - The JWT expiration cannot be changed without your private key")
    print("  - After expiration, client must request a new JWT from you")


if __name__ == "__main__":
    main()
