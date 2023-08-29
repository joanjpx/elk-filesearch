#!/bin/bash

# Directorio a monitorear
DIR_MONITOREO="/data"

# Función para monitorear subcarpetas de manera recursiva
monitorizar_subcarpetas() {
    inotifywait -m -r -e create,modify,delete --format '%w%f %e' "$1" |
    while read path_event file; do
        event="${path_event##* }"
        path="${path_event% *}"
        echo "Evento '$event' en: $path$file"
        php elk-upload.php "$path$file"
    done
}

# Monitorear el directorio principal y todas las subcarpetas
monitorizar_subcarpetas "$DIR_MONITOREO"
