baseRepo=gurkalov
buildImage=${image}
buildContainer=build-$(buildImage)
IMAGE := $(or ${image},${image},eva-position)
TAG := ":$(or ${tag},${tag},"latest")"

tag:
	docker tag $(baseRepo)/${IMAGE} $(baseRepo)/${IMAGE}${TAG}

build:
	docker build -t $(baseRepo)/${IMAGE} .

push:
	make tag
	docker push $(baseRepo)/${IMAGE}

down:
	docker-compose down ${flag}

reset:
	docker-compose down -v
	docker-compose up -d

reset-out:
	docker-compose down
	docker-compose up

test:
	ab -c 10 -n 500 http://${target}/

test-static:
	ab -c 10 -n 500 http://${target}/static.txt

test-post:
	ab -p data.json -T application/json -c 10 -n 50000 http://${target}

full:
	make build image=app
	make build-nginx
	make reset

remote-install:
	ssh root@$(server) "curl -L https://github.com/docker/compose/releases/download/1.21.0/docker-compose-Linux-x86_64 > docker-compose"
	ssh root@$(server) cp ./docker-compose /usr/local/bin/docker-compose
	ssh root@$(server) chmod +x /usr/local/bin/docker-compose

remote-deploy:
	make build image=app
	make build-nginx
	make push image=app
	make push image=nginx
	ssh root@$(server) docker pull ognestraz/lumen-app
	ssh root@$(server) docker pull ognestraz/lumen-nginx
	scp docker-compose.production.yml root@$(server):docker-compose.yml
	ssh root@$(server) docker-compose down -v
	ssh root@$(server) docker-compose up

remote-reload:
	ssh root@$(server) docker-compose down
	ssh root@$(server) docker-compose up

remote-reset:
	ssh root@$(server) docker-compose down -v
	ssh root@$(server) docker-compose up