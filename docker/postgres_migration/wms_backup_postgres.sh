
export PGPASSWORD="100pbcp"

docker run --env PGPASSWORD=$PGPASSWORD --rm -it postgres:latest pg_dump -d 100pbcd -h 10.197.3.140 -p 4080 -U 100pbcu | gzip > out2.sql.gz
