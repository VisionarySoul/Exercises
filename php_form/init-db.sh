#!/bin/bash

# Wait for PostgreSQL to start
echo "Waiting for PostgreSQL to start..."
until pg_isready -U postgres; do
  sleep 1
done

# Create the `postgres` user if it doesn't exist
echo "Creating the 'postgres' role..."
psql -U postgres -c "DO \$\$ BEGIN IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'postgres') THEN CREATE ROLE postgres SUPERUSER LOGIN; END IF; END \$\$;"

# Create the `mydb` database if it doesn't exist
echo "Creating the 'mydb' database..."
psql -U postgres -c "DO \$\$ BEGIN IF NOT EXISTS (SELECT 1 FROM pg_database WHERE datname = 'mydb') THEN CREATE DATABASE mydb; END IF; END \$\$;"

# Ensure the permissions are set correctly
echo "Setting permissions..."
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE mydb TO postgres;"

echo "Database initialization completed."
