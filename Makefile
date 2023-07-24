stop:
	bash docker/bin/stop.sh
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
env.dev:
	bash docker/bin/env.dev.sh
env.prod:
	bash docker/bin/env.prod.sh
start.dev:
	bash docker/bin/env.dev.sh && bash docker/bin/start.sh dev && bash docker/bin/env.dev.sh
restart.dev:
	bash docker/bin/stop.sh && bash docker/bin/env.dev.sh && bash docker/bin/start.sh dev && bash docker/bin/env.dev.sh
start.prod:
	bash docker/bin/env.prod.sh && bash docker/bin/start.sh prod && bash docker/bin/env.prod.sh
restart.prod:
	bash docker/bin/stop.sh && bash docker/bin/env.prod.sh && bash docker/bin/start.sh prod && bash docker/bin/env.prod.sh