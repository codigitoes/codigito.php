all-dev: stop env-dev start-dev env-dev install recreatedb dumpdb rabbit
all-prod:
	bash docker/bin/stop.sh ; \
	bash docker/bin/env.prod.sh && bash docker/bin/start.sh prod && bash docker/bin/env.prod.sh; \
	bash docker/bin/install.sh; \
	bash docker/bin/recreatedb.sh; \ 
	bash docker/bin/rabbit.sh ; \
	bash docker/bin/dumpdb.sh 
stop:
	bash docker/bin/stop.sh
apish:
	bash docker/bin/apish.sh 
adminsh:
	bash docker/bin/adminsh.sh
wwwsh:
	bash docker/bin/wwwsh.sh
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
