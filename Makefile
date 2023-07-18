start:
	bash docker/bin/start.sh &
stop:
	bash docker/bin/stop.sh
restart:
	bash docker/bin/stop.sh ; bash docker/bin/start.sh &
apish:
	bash docker/bin/apish.sh
adminsh:
	bash docker/bin/adminsh.sh
wwwsh:
	bash docker/bin/wwwsh.sh
tests:
	bash docker/bin/tests.sh
test: tests
truncatealltables:
	bash docker/bin/truncatealltables.sh
dumpdb:
	bash docker/bin/dumpdb.sh
install:
	bash docker/bin/install.sh
recreatedb:
	bash docker/bin/recreatedb.sh
format:
	bash docker/bin/format.sh

envdev:
	cp api/.env.template api/.env
	cp admin/.env.template admin/.env
	cp www/.env.template www/.env
envprod:
	cp api/.env.production api/.env
	cp admin/.env.production admin/.env
	cp www/.env.production www/.env
