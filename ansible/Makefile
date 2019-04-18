DOCKER_SSH_KEY := $(shell cat ~/.ssh/id_rsa.pub)
NODE_IP := 172.37.0.77
NODE_NAME := ansible-eva-app-test
PRIVATE_KEY := roles/gurkalov.deploy_user/files/id_rsa
NETWORK := eva
SUBNET := 172.37.0.0/16
ENV := $(or ${env},${env},local)
USER := $(or ${user},${user},root)
INVENTORY := inventories/$(ENV)

.PHONY : test

network-create:
	docker network create --subnet=$(SUBNET) $(NETWORK) || true

network-remove:
	docker network rm $(NETWORK)

server:
	make network-create
	docker run --net $(NETWORK) --ip $(NODE_IP) --name $(NODE_NAME) -itd -P -e SSH_KEY="$(DOCKER_SSH_KEY)" gurkalov/ubuntu-ssh:bionic
	sleep 1
	ssh-keyscan -t rsa -H $(NODE_IP) >> ~/.ssh/known_hosts

down:
	docker rm -f $(NODE_NAME) || true
	ssh-keygen -f ~/.ssh/known_hosts -R $(NODE_IP)
	make network-remove

deploy:
	ansible-playbook -i $(INVENTORY) -u deploy deploy.yml --tags=deploy

docker-deploy:
	ansible-playbook -i $(INVENTORY) -u deploy docker-deploy.yml --tags=deploy

migrate:
	ansible-playbook -i $(INVENTORY) -u deploy deploy.yml --tags=migrate

seed:
	ansible-playbook -i $(INVENTORY) -u deploy deploy.yml --tags=seed

app:
	ansible-playbook -i $(INVENTORY) -u $(USER) deploy.yml --tags=setup

setup:
	ansible-playbook -i $(INVENTORY) -u $(USER) bootstrap.yml
	ansible-playbook -i $(INVENTORY) -u $(USER) server.yml --tags=user
	ansible-playbook -i $(INVENTORY) -u $(USER) server.yml --tags=php
	ansible-playbook -i $(INVENTORY) -u $(USER) server.yml --tags=nginx
	ansible-playbook -i $(INVENTORY) -u $(USER) server.yml --tags=redis
	ansible-playbook -i $(INVENTORY) -u $(USER) mysql.yml
	make app

docker-setup:
	ansible-playbook -i $(INVENTORY) -u root bootstrap.yml
	ansible-playbook -i $(INVENTORY) -u root server.yml --tags=user
	ansible-playbook -i $(INVENTORY) -u root docker.yml
	ansible-playbook -i $(INVENTORY) -u root docker-deploy.yml

reboot:
	make down
	make server
	make setup

codecept:
	cd ../tests && php vendor/bin/codecept run $(ENV)

codecept-production:
	cd ../tests && php vendor/bin/codecept run $(ENV) PositionCest

test:
	make down
	make server
	make setup
	make codecept
