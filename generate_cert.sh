#!/bin/bash

set -o allexport
source .env
set +o allexport

mkcert -install

if [ ! -f certs/key.pem ]; then
  echo "Generating certificate...."

  mkcert -key-file=certs/key.pem -cert-file=certs/cert.pem -client "*.${APP_NAME}.localhost"

  echo "Generation successfull"
else
  echo "Certificate exists. Skipping..."
fi