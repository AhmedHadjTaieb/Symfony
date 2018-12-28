#! /bin/bash

sudo chown -R $(whoami):$(whoami) $(pwd)
setfacl -dR -m u:$(whoami):rwX -m u:$(whoami):rwX $(pwd)
setfacl -R -m u:$(whoami):rwX -m u:$(whoami):rwX $(pwd)
sudo chown -R www-data:www-data $(pwd)

docker-compose --project-name opclroom -f $(pwd)/ENV/docker-compose.yml  down -v
docker-compose --project-name opclroom -f $(pwd)/ENV/docker-compose.yml up --build -d