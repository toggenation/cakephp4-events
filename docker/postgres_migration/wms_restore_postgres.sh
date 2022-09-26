
export PGPASSWORD="100pbcp"

zcat out2.sql.gz | docker run --env PGPASSWORD=$PGPASSWORD -a stdin --rm -i postgres:latest psql -d 100pbcd -h 10.197.3.140 -p 4080 -U 100pbcu
