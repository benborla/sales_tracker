#!/usr/bin/env sh

jwt_passphrase=$(grep '^JWT_PASSPHRASE=' .env | cut -f 2 -d '=')
echo "Generating public / private keys for JWT"
mkdir -p ./config/jwt
echo "$jwt_passphrase" | openssl genpkey -out ./config/jwt/private.pem -pass stdin -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:1024
echo "$jwt_passphrase" | openssl pkey -in ./config/jwt/private.pem -passin stdin -out ./config/jwt/public.pem -pubout
