#!/bin/sh

host="$1"
port="$2"

echo "⏳ Czekam na bazę danych $host:$port..."

while ! nc -z "$host" "$port"; do
  sleep 1
done

echo "✅ Baza danych $host:$port gotowa!"