DOCKER_SSH_KEY := $(shell cat ~/.ssh/id_rsa.pub)
NODE_IP := 172.37.0.77
NODE_NAME := ansible-eva-app-test
PRIVATE_KEY := roles/gurkalov.deploy_user/files/id_rsa
NETWORK := eva
SUBNET := 172.37.0.0/16
ENV := $(or ${env},${env},local)
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

app:
	ansible-playbook -i $(INVENTORY) -u root deploy.yml

setup:
	ansible-playbook -i $(INVENTORY) -u root bootstrap.yml
	ansible-playbook -i $(INVENTORY) -u root server.yml --tags=user
	ansible-playbook -i $(INVENTORY) -u root server.yml --tags=php
	ansible-playbook -i $(INVENTORY) -u root server.yml --tags=nginx
	ansible-playbook -i $(INVENTORY) -u root mysql.yml
	make app

reboot:
	make down
	make server
	make setup

codecept:
	cd ../tests && codecept run docker

codecept-production:
	cd ../tests && codecept run production

test:
	make down
	make server
	make setup
	make codecept
