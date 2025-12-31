# OXID eShop Docker Setup for Windows

Run OXID eShop 7.3 on Windows using Docker Desktop - no WSL or Linux subsystem required.

## Requirements

- [Docker Desktop for Windows](https://www.docker.com/products/docker-desktop/) (uses Hyper-V)
- Git

## Quick Start

```bash
# Clone the repository
git clone git@github.com:MartinPirate/oxid-esales-windows.git
cd oxid-esales-windows

# Start OXID eShop
docker-compose up -d

# First run takes ~5 minutes (downloads and installs OXID)
# Check progress with:
docker logs -f oxid_php
```

## Access URLs

| Service | URL |
|---------|-----|
| OXID Shop | http://localhost |
| Setup Wizard | http://localhost/Setup |
| Adminer (Database) | http://localhost:8080 |
| Mailpit (Email Testing) | http://localhost:8025 |

## Database Credentials

Use these in the OXID setup wizard:

| Field | Value |
|-------|-------|
| Database Host | `mysql` |
| Database Port | `3306` |
| Database Name | `oxid` |
| Database User | `oxid` |
| Database Password | `oxid` |

## Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# View PHP logs only
docker logs -f oxid_php

# Access PHP container shell
docker exec -it oxid_php bash

# Access MySQL
docker exec -it oxid_mysql mysql -u oxid -poxid oxid

# Rebuild containers (after config changes)
docker-compose up -d --build

# Full reset (removes all data)
docker-compose down -v
docker-compose up -d --build
```

## Project Structure

```
oxid-esales-windows/
├── docker-compose.yml          # Main Docker configuration
├── docker/
│   ├── php/
│   │   ├── Dockerfile          # PHP 8.2-FPM with OXID extensions
│   │   └── entrypoint.sh       # Auto-installs OXID on first run
│   └── apache/
│       ├── Dockerfile          # Apache 2.4 with mod_rewrite
│       └── oxid.conf           # Virtual host configuration
├── .env                        # Environment variables
├── .gitignore
└── README.md
```

## Stack

- **PHP** 8.2-FPM
- **Apache** 2.4 with mod_rewrite
- **MySQL** 8.0
- **OXID eShop** 7.3 Community Edition
- **Adminer** - Database management
- **Mailpit** - Email testing

## PHP Extensions Included

All extensions required by OXID:
- GD (with JPEG/PNG support)
- PDO MySQL
- BCMath
- mbstring
- SOAP
- ZIP
- OPcache
- cURL (built-in)
- DOM, JSON, iconv, tokenizer (built-in)

## Troubleshooting

### Port 80 already in use
Stop any service using port 80 (IIS, Skype, etc.) or change the port in `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Access via http://localhost:8081
```

### Database connection error in setup
Make sure to use `mysql` as the host, not `localhost`.

### Permission errors
The setup automatically handles permissions. If issues persist:
```bash
docker exec oxid_php bash -c "chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html"
```

### Container won't start
Check Docker Desktop is running and has enough resources allocated (minimum 4GB RAM recommended).

### Reset everything
```bash
docker-compose down -v
docker-compose up -d --build
```

## Development

### Branching Strategy

- `main` - Stable releases
- `dev` - Development branch

### Contributing

1. Fork the repository
2. Create a feature branch from `dev`
3. Make your changes
4. Submit a pull request to `dev`

## License

MIT License
