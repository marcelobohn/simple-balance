#!/usr/bin/env bash

# Ensure we run under bash even if invoked with `sh`
if [ -z "${BASH_VERSION:-}" ]; then
  exec bash "$0" "$@"
fi

set -euo pipefail

cmd=${1:-}

usage() {
  echo "Usage: $0 {start|stop|remove}" >&2
  exit 1
}

[[ -n "$cmd" ]] || usage

case "$cmd" in
  start)
    docker compose up --build -d
    ;;
  stop)
    docker compose down
    ;;
  remove)
    # Stop containers and remove images built by this compose project
    docker compose down --rmi local
    ;;
  *)
    usage
    ;;
esac
