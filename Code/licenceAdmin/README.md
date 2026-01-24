# Licence Admin - Secure JSON Distribution System

A Python utility for encrypting JSON data with self-expiring, tamper-proof keys for client applications.

## Overview

This system allows you to:
- Encrypt JSON configuration/license data once
- Generate unique, self-expiring JWT keys for each client
- Distribute encrypted data securely to Laravel applications
- Prevent data modification by clients
- Control access through time-based key expiration

## Architecture

```
┌─────────────────────┐
│  Your Python App    │  (Admin Side)
│  ===============    │
│  • Master Private   │
│    Keys (RSA)       │
│  • Encrypts JSON    │
│  • Signs JWT        │
└──────────┬──────────┘
           │
           │ Sends: encrypted_data.enc + key.jwt
           │
           ▼
┌─────────────────────┐
│  Client Laravel     │  (Client Side)
│  ===============    │
│  • Public Key       │
│  • Verifies JWT     │
│  • Decrypts in      │
│    memory           │
└─────────────────────┘
```

## Security Features

✅ **Tamper Proof**: Data encrypted with Fernet (HMAC-authenticated)  
✅ **Self-Expiring**: JWT tokens have built-in expiration  
✅ **Asymmetric Security**: Private key never leaves your system  
✅ **Unique Per Client**: Each client has their own RSA key pair  
✅ **No Modification**: Clients cannot alter data or extend key validity  

## Installation

1. Install Python dependencies:

```bash
pip install -r requirements.txt
```

## Quick Start

### Step 1: Generate Client Keys

For each new client, generate a unique RSA key pair:

```bash
python generate_client_keys.py client_001
```

This creates:
- `keys/client_001/private.pem` (Keep this SECRET on your system)
- `keys/client_001/public.pem` (Send this to the client)

### Step 2: Encrypt Your Data

Encrypt a JSON file and create a self-expiring key:

```bash
python encrypt_data.py example_secrets.json client_001
```

Optional: Specify custom expiration (in days):

```bash
python encrypt_data.py example_secrets.json client_001 --days 180
```

### Step 3: Distribute to Client

Send these files to your client:
- `output/client_001_data.enc` - The encrypted JSON data
- `output/client_001_key.jwt` - The access key (valid for 1 year by default)
- `keys/client_001/public.pem` - The public verification key (one-time setup)

### Step 4: Client Setup (Laravel)

The client should install the required PHP package:

```bash
composer require paragonie/fernet firebase/php-jwt
```

And use this decryption service in their Laravel app:

```php
<?php
namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ParagonIE\Fernet\Fernet;

class SecureDecryptor {
    public function decryptData($encryptedData, $jwtToken) {
        try {
            // Load the public key (stored in storage/keys/public.pem)
            $publicKey = file_get_contents(storage_path('keys/public.pem'));

            // Verify JWT signature and expiration
            $decoded = JWT::decode($jwtToken, new Key($publicKey, 'RS256'));

            // Extract the data key from the validated JWT
            $dataKey = $decoded->dk;

            // Decrypt the JSON in memory
            $fernet = new Fernet($dataKey);
            $decryptedJson = $fernet->decode($encryptedData);

            return json_decode($decryptedJson, true);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return ["error" => "Key expired. Please request a new key."];
        } catch (\Exception $e) {
            return ["error" => "Invalid or tampered key."];
        }
    }
}
```

## Usage Examples

### Generate Keys for Multiple Clients

```bash
python generate_client_keys.py client_001
python generate_client_keys.py client_002
python generate_client_keys.py acme_corp
```

### Encrypt Data for Different Clients

```bash
# Standard license (1 year)
python encrypt_data.py license_standard.json client_001

# Trial license (30 days)
python encrypt_data.py license_trial.json client_002 --days 30

# Enterprise license (2 years)
python encrypt_data.py license_enterprise.json acme_corp --days 730
```

### Renew an Expired Key

When a client's key expires, simply re-encrypt with a new expiration date:

```bash
python encrypt_data.py license_standard.json client_001 --days 365
```

Send them the new JWT file. The encrypted data file remains the same if the JSON content hasn't changed.

## File Structure

```
licenceAdmin/
├── encrypt_data.py              # Main encryption utility
├── generate_client_keys.py      # Key pair generator
├── requirements.txt             # Python dependencies
├── README.md                    # This file
├── example_secrets.json         # Example JSON data
├── keys/                        # Client RSA keys (PRIVATE - DO NOT SHARE)
│   ├── client_001/
│   │   ├── private.pem         # Used by you to sign JWTs
│   │   └── public.pem          # Sent to client for verification
│   └── client_002/
│       ├── private.pem
│       └── public.pem
└── output/                      # Generated files to send to clients
    ├── client_001_data.enc      # Encrypted JSON
    └── client_001_key.jwt       # Self-expiring key
```

## How It Works

1. **Encryption Layer**: Your JSON is encrypted with Fernet (AES-128 + HMAC)
2. **Key Wrapping**: The Fernet key is embedded in a JWT payload
3. **Signing**: The JWT is signed with your RSA private key
4. **Expiration**: The JWT contains an `exp` claim (self-expiring)
5. **Distribution**: Client receives encrypted data + signed JWT
6. **Verification**: Client's Laravel app verifies JWT with public key
7. **Decryption**: If valid and not expired, the data is decrypted in memory

## Security Best Practices

⚠️ **CRITICAL**: 
- Never share your `keys/*/private.pem` files
- Store private keys securely (encrypted drive, password manager, HSM)
- Use version control ignore for the `keys/` directory
- Only send `public.pem` files to clients

🔒 **Recommendations**:
- Rotate client keys periodically
- Use shorter expiration times for sensitive data
- Keep audit logs of key generation and distribution
- Consider using environment variables for key paths in production

## Troubleshooting

### "Private key not found"
Run `python generate_client_keys.py <client_id>` first.

### "Invalid JSON format"
Validate your JSON file at [jsonlint.com](https://jsonlint.com)

### "ModuleNotFoundError"
Install dependencies: `pip install -r requirements.txt`

### Client can't decrypt
- Verify client has the correct `public.pem` file
- Check JWT hasn't expired
- Ensure client is using `paragonie/fernet` package

## Advanced Configuration

### Custom JWT Claims

Edit `encrypt_data.py` to add custom claims:

```python
payload = {
    "iss": "LicenceAdmin-SecureDistributor",
    "sub": client_id,
    "exp": expiry_date,
    "dk": data_key.decode(),
    "custom_field": "your_value",  # Add your custom claims
    "client_tier": "enterprise"
}
```

### Batch Processing

Create a script to encrypt for multiple clients:

```bash
#!/bin/bash
for client in client_001 client_002 client_003; do
    python encrypt_data.py config.json $client --days 365
done
```

## License

This utility is part of the KubeOps project.

## Support

For issues or questions, contact your system administrator.
