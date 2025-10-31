Load-Balanced PHP + PostgreSQL Stack
====================================

This project spins up two PHP-FPM containers behind an Nginx load balancer with a PostgreSQL database. Use Docker Compose to bring the stack up and down, then verify the round-robin balancing with simple `curl` requests.

Bring Everything Up
-------------------

```bash
docker compose up --build -d
```

Stop and Remove Containers
--------------------------

```bash
docker compose down
```

Verify the Load Balancer
------------------------

Hit the Nginx endpoint repeatedly to see different container hostnames in the response.

```bash
curl -i http://localhost:8080/
curl -i http://localhost:8080/  # repeat as needed
```

Check Each PHP Container Directly
---------------------------------

```bash
curl -i http://localhost:9001/
curl -i http://localhost:9002/
```

Tail Nginx Logs (optional)
--------------------------

```bash
docker compose logs -f nginx-lb
```
