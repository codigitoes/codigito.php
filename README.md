 **MARCAS DE REEMPLAZOS**

codigito       => usuario base de datos
codigito       => password base de datos
codigito       => nombre base de datos
codigito       => directorio document_root / var/www/vhosts/DOCUMENT_ROOT
codigito       => prefijo para los nombres de los contenedores

** Puesta en marcha **

1. reemplazar todas las marcas
2. make start
3. make apish
4. bash /tmp/firstboot.sh

** Resources **

docker/resources/phpunit.xml.dist

Este fichero lo usaremos en los contenedores que necesites
phpunit y debemos modificar las lineas de las rutas 

linea 16

<directory>contexts/XXXXXX</directory>

la ruta es desde el directorio raiz del proyecto,
ahi es donde copiamos este fichero.


docker/resources/composer.json

Este fichero lo usaremos para incluir en las secciones
de require y require-dev el fuente de nuestros componentes
asi como la ruta a los test.

Las rutas las definimos junto a sus namespaces

"autoload": {
    "psr-4": {
        "App\\": "src/",
        ...
        ...
        "ROOTNSDIR\\AAAAA\\BBBBB\\": "ROOTNSDIR/AAAAA/BBBBB/src/",
        ...
        ...
    }
},
"autoload-dev": {
    "psr-4": {
        "App\\Tests\\": "tests/",
        ...
        ...
        "ROOTNSDIR\\AAAAA\\BBBBB\\Test\\": "ROOTNSDIR/AAAAA/BBBBB/test/",
        ...
        ...
    }
},

Con estos datos debemos poner en la raiz del proyecto los siguientes
directorios

ROOTNSDIR/AAAAA/BBBBB/src
ROOTNSDIR/AAAAA/BBBBB/test

y los namespace tanto del fuente como del test seria

namespace ROOTNSDIR\AAAAA\BBBBB\Domain

para una clase localizada en

ROOTNSDIR/AAAAA/BBBBB/src/Domain

y el namespace

namespace ROOTNSDIR\AAAAA\BBBBB\Test\Unit\Domain

seria para una clase localizada en

ROOTNSDIR/AAAAA/BBBBB/test/Unit/Domain
