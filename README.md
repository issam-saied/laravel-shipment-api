# Laravel Shipment Options API

This project is a Laravel-based API that calculates available shipment options based on a set of business rules involving carriers, package types, destinations, and shipment dates.

The project was built as a personal exercise to experiment with API design, domain modeling, and backend architecture using Laravel.

It focuses on clean code structure, validation, service layer logic, and containerized development.

---

## Features

- REST API endpoint for retrieving shipment options
- Business rules for carriers, package types, regions, and weekend availability
- Request validation using Laravel Form Requests
- API Resources for consistent JSON responses
- Service layer for business logic separation
- Eloquent models for domain entities
- Docker-based development environment
- Automated tests

---

## Shipment Logic

Shipment options depend on the following parameters:

- Destination country
- Shipment date
- Package type

Based on these inputs, the system determines:

- Which carriers support the shipment
- Whether the carrier operates during weekends
- The correct shipping price

The API returns all available shipment options matching the request.

---

## Tech Stack

- PHP
- Laravel
- MySQL
- Docker
- Nginx
- PHPUnit

---

## Project Structure

```
project-root
├── docker/
│   ├── nginx/
│   └── php/
├── src/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers
│   │   │   ├── Requests
│   │   │   └── Resources
│   │   ├── Models
│   │   └── Services
│   ├── routes/
│   └── tests/
├── docker-compose.yml
└── README.md
```

---

## Running the Project

Start the Docker environment:

```
docker compose up -d --build
```

Install dependencies:

```
docker compose exec app composer install
```

Generate application key:

```
docker compose exec app php artisan key:generate
```

Run database migrations:

```
docker compose exec app php artisan migrate
```

---

## Example API Endpoint

```
GET /api/shipment-options
```

Example query parameters:

```
country=NL
package_type=standard
shipment_date=2024-01-10
```

---

## Testing

Run the test suite:

```
docker compose exec app php artisan test
```

Tests include:

- Feature tests for API endpoints
- Unit tests for shipment option logic

---

## Purpose

This repository is shared as an example project to demonstrate Laravel backend development, API design, and application architecture.