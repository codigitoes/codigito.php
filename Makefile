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