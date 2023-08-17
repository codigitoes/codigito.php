all-dev:
	bash infrastructure/docker/bin/stop.sh ; \
	bash infrastructure/docker/bin/env.dev.sh && bash infrastructure/docker/bin/start.sh dev && bash infrastructure/docker/bin/env.dev.sh; \
	bash infrastructure/docker/bin/recreatedb.sh ; \
	bash infrastructure/docker/bin/rabbit.sh ; \
	bash infrastructure/docker/bin/dumpdb.sh 
all-prod:
	bash infrastructure/docker/bin/stop.sh ; \
	bash infrastructure/docker/bin/env.prod.sh && bash infrastructure/docker/bin/start.sh prod && bash infrastructure/docker/bin/env.prod.sh; \
	bash infrastructure/docker/bin/install.sh; \
	bash infrastructure/docker/bin/recreatedb.sh; \ 
	bash infrastructure/docker/bin/rabbit.sh ; \
	bash infrastructure/docker/bin/dumpdb.sh 
pre: 
	bash infrastructure/docker/bin/stop.sh
prod: 
	bash infrastructure/docker/bin/install.sh   ; \
	bash infrastructure/docker/bin/dumpdb.sh   ; \
	bash infrastructure/docker/bin/rabbit.sh
stop:
	bash infrastructure/docker/bin/stop.sh
apish:
	bash infrastructure/docker/bin/apish.sh 
adminsh:
	bash infrastructure/docker/bin/adminsh.sh
wwwsh:
	bash infrastructure/docker/bin/wwwsh.sh
rabbitsh:
	bash infrastructure/docker/bin/rabbitsh.sh
tests:
	bash infrastructure/docker/bin/tests.sh
truncatealltables:
	bash infrastructure/docker/bin/truncatealltables.sh
dumpdb:
	bash infrastructure/docker/bin/dumpdb.sh
install: 
	bash infrastructure/docker/bin/install.sh
rabbit:
	bash infrastructure/docker/bin/rabbit.sh
recreatedb:
	bash infrastructure/docker/bin/recreatedb.sh
format:
	bash infrastructure/docker/bin/format.sh
env-dev:
	bash infrastructure/docker/bin/env.dev.sh
env-prod:
	bash infrastructure/docker/bin/env.prod.sh
restart-api-dev:
	bash infrastructure/docker/bin/restart.sh dev codigito.api
start-dev:
	bash infrastructure/docker/bin/stop.sh ; bash infrastructure/docker/bin/env.dev.sh && bash infrastructure/docker/bin/start.sh dev && bash infrastructure/docker/bin/env.dev.sh 
start-prod:
	bash infrastructure/docker/bin/stop.sh ; bash infrastructure/docker/bin/env.prod.sh && bash infrastructure/docker/bin/start.sh prod && bash infrastructure/docker/bin/env.prod.sh
