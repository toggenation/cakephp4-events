docker run --rm -it -v "$(pwd)/pgload.load:/pgload.load" dimitri/pgloader:latest \
    pgloader /pgload.load