#!/usr/bin/env python3
"""
RSA Key Pair Generator for Clients

This utility generates unique RSA public/private key pairs for each client.
The private key stays with you (admin), and the public key is given to the client's Laravel application.

Usage:
    python generate_client_keys.py <client_id>

Example:
    python generate_client_keys.py client_001
"""

import os
import sys
from cryptography.hazmat.primitives.asymmetric import rsa
from cryptography.hazmat.primitives import serialization
from cryptography.hazmat.backends import default_backend


def generate_key_pair(client_id):
    """
    Generate an RSA key pair for a specific client.
    
    Args:
        client_id (str): Unique identifier for the client
        
    Returns:
        tuple: (private_key_path, public_key_path)
    """
    # Create the keys directory structure
    keys_dir = os.path.join("keys", client_id)
    os.makedirs(keys_dir, exist_ok=True)
    
    # Generate private key
    private_key = rsa.generate_private_key(
        public_exponent=65537,
        key_size=2048,
        backend=default_backend()
    )
    
    # Generate public key
    public_key = private_key.public_key()
    
    # Save private key
    private_key_path = os.path.join(keys_dir, "private.pem")
    with open(private_key_path, "wb") as f:
        f.write(
            private_key.private_bytes(
                encoding=serialization.Encoding.PEM,
                format=serialization.PrivateFormat.PKCS8,
                encryption_algorithm=serialization.NoEncryption()
            )
        )
    
    # Save public key
    public_key_path = os.path.join(keys_dir, "public.pem")
    with open(public_key_path, "wb") as f:
        f.write(
            public_key.public_bytes(
                encoding=serialization.Encoding.PEM,
                format=serialization.PublicFormat.SubjectPublicKeyInfo
            )
        )
    
    return private_key_path, public_key_path


def main():
    if len(sys.argv) < 2:
        print("Error: Please provide a client ID")
        print("Usage: python generate_client_keys.py <client_id>")
        print("Example: python generate_client_keys.py client_001")
        sys.exit(1)
    
    client_id = sys.argv[1]
    
    # Validate client_id (basic sanitization)
    if not client_id.replace("_", "").replace("-", "").isalnum():
        print("Error: Client ID must contain only alphanumeric characters, hyphens, or underscores")
        sys.exit(1)
    
    print(f"Generating RSA key pair for client: {client_id}")
    
    try:
        private_path, public_path = generate_key_pair(client_id)
        print(f"✓ Keys generated successfully!")
        print(f"  Private Key (KEEP SECRET): {os.path.abspath(private_path)}")
        print(f"  Public Key (Send to client): {os.path.abspath(public_path)}")
        print()
        print("⚠️  IMPORTANT:")
        print(f"  1. Keep the private key ({private_path}) secure on your system")
        print(f"  2. Send {public_path} to the client's Laravel application")
        print(f"  3. The client should place it in: storage/keys/public.pem")
    except Exception as e:
        print(f"Error generating keys: {e}")
        sys.exit(1)


if __name__ == "__main__":
    main()
