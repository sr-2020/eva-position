current_dir = $(shell pwd)

load:
	docker run -v $(current_dir)/loadtest:/var/loadtest --net host --entrypoint /bin/bash -it direvius/yandex-tank
