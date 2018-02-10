```sh
	docker pull elgalu/selenium
	docker run -d --name=grid -p 4444:24444 -p 5900:25900 -e TZ="US/Pacific" -v /dev/shm:/dev/shm --privileged elgalu/selenium
	# optional
	docker exec grid wait_all_done 30s

	composer install
	./vendor/bin/phpunit test.php
```
