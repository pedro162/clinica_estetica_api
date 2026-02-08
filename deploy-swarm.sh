#!/bin/bash

echo "🚀 Iniciando Build das imagens..."
docker-compose build

echo "📦 Enviando imagens para o Registro Local (localhost:5000)..."
docker-compose push

echo "🌐 Fazendo deploy da Stack no Swarm..."
docker stack deploy -c docker-stack.yml minha_clinica

echo "✅ Status dos serviços:"
docker service ls