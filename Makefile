all-dev: 
	make stop && make env-dev && make start-dev &&  make env-dev && make install && make recreatedb && make dumpdb && make rabbit
all-prod: stop env-prod start-prod env-prod install recreatedb dumpdb rabbit
stop:
	bash docker/bin/stop.sh
apish:
	bash docker/bin/apish.sh 
frontendsh:
	bash docker/bin/frontendsh.sh 
adminsh:
	bash docker/bin/adminsh.sh
rabbitsh:
	bash docker/bin/rabbitsh.sh
tests:
	bash docker/bin/tests.sh
truncatealltables:
	bash docker/bin/truncatealltables.sh
dumpdb:
	bash docker/bin/dumpdb.sh
install: 
	bash docker/bin/install.sh
rabbit:
	bash docker/bin/rabbit.sh
recreatedb:
	bash docker/bin/recreatedb.sh
format:
	bash docker/bin/format.sh
env-dev:
	bash docker/bin/env.dev.sh
env-prod:
	bash docker/bin/env.prod.sh
restart-api-dev:
	bash docker/bin/restart.sh dev codigito.api
start-dev:
	bash docker/bin/stop.sh ; bash docker/bin/env.dev.sh && bash docker/bin/start.sh dev && bash docker/bin/env.dev.sh 
start-prod:
	bash docker/bin/stop.sh ; bash docker/bin/env.prod.sh && bash docker/bin/start.sh prod && bash docker/bin/env.prod.sh
