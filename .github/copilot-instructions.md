## Purpose

Provide concise, actionable guidance for AI coding agents working on this repo so they can be productive immediately.

## Big-picture architecture

- Multi-container Docker app managed with `docker-compose.yml`.
- Services:
  - `postgres_db` (PostgreSQL 16) — persistent volume `postgres-data`.
  - `php-app-1` and `php-app-2` — PHP-FPM containers built from `Dockerfile`, both mount `./app` into `/var/www/html/public`.
  - `nginx-lb` — Nginx reverse-proxy / load‑balancer; config at `nginx/conf.d/app.conf` defines an `upstream php-app` pointing to `php-app-1:9000` and `php-app-2:9000`.

Dataflow: Nginx receives HTTP on host port 8080, forwards PHP requests to the PHP-FPM upstream (the two PHP containers). The PHP app connects to `postgres_db:5432` using credentials defined in `docker-compose.yml` and `app/database.php`.

## How to run (developer workflow)

- Start everything locally (rebuild if Dockerfile changed):

  docker-compose up --build -d

- View logs:

  docker-compose logs -f nginx-lb

- Open the app in a browser: http://localhost:8080 — `index.php` displays the container hostname to demonstrate load balancing.

- PHP-FPM debugging: two PHP containers expose internal port 9000. The compose file maps them to host ports 9001 and 9002 for easy access:
  - php-app-1 -> host:9001
  - php-app-2 -> host:9002

## Key files and what they demonstrate

- `docker-compose.yml` — primary orchestration and service env vars (search for `POSTGRES_*`).
- `Dockerfile` — builds PHP-FPM image and installs `pdo_pgsql` via `docker-php-ext-install`.
- `nginx/conf.d/app.conf` — Nginx server + `upstream` block that defines load balancing to `php-app-1:9000` and `php-app-2:9000`.
- `app/index.php` — application entry; includes `app/database.php` to show DB connectivity test and HTML output.
- `app/database.php` — PDO connection to `postgres_db` using hard-coded creds (host `postgres_db`, port `5432`).

## Project-specific conventions and patterns

- App code is mounted read-write from `./app` into `/var/www/html/public`. Editing PHP files locally takes effect immediately without rebuilding the image.
- PHP-FPM image is built from the repo `Dockerfile`. Changes to the `Dockerfile` require `docker-compose up --build`.
- DB credentials are currently in two places: `docker-compose.yml` (Postgres env) and `app/database.php` (hard-coded). When editing code, keep these in sync.

## Integration points and external dependencies

- PostgreSQL is a local service (no external cloud DB). External systems are not used by default.
- The environment expects Docker and docker-compose to be installed on the developer machine.

## Debugging tips and examples

- If DB connection fails, inspect Postgres logs:

  docker-compose logs -f postgres_db

- To run a quick psql shell inside the DB container:

  docker exec -it $(docker ps -qf "name=postgres_db") psql -U myuser -d mydatabase

- To test a specific PHP container's response (bypass nginx):

  curl http://localhost:9001/

## Notes / caveats

- Credentials are hard-coded for convenience in development. For production or more complex local workflows, prefer environment-driven configuration and do not commit secrets.
- There are no automated tests in the repo; treat any changes to the Dockerfile or compose services as requiring manual validation via the steps above.

---

If anything here is unclear or you want additional examples (e.g., how to add environment variable support in `app/database.php` or a minimal health-check), tell me which area to expand and I will update this file.
