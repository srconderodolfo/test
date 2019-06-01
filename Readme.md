# Requisitos
- Docker-compose 
- Docker

# Como usar?
Na pasta do projeto, rode:
```
docker-compose up
```
Acesse http://localhost:8090

# URL
    http://localhost:8090/markers/{northeast}/{southwest}/{zoom}/{radius}

* {northeast}/{southwest}
    Área do boundingBox separado por virgula com latitude e longitude, exemplo:
    -23.36903060852871,-46.58352461146353/-23.477401171710508,-46.77853193568228


# URL de exemplo:
http://localhost:8090/markers/-23.36903060852871,-46.58352461146353/-23.477401171710508,-46.77853193568228/15/20