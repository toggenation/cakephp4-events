# pgloader mysql://100pbcu:100pbcp@mysql/100pbcd postgresql://100pbcu:100pbcp@postgres/100pbcd
# working
docker run --rm -it dimitri/pgloader:latest pgloader mysql://100pbc:100pbc@10.197.3.140:4050/100pbcd postgresql://100pbcu:100pbcp@10.197.3.140:4080/100pbcd

# run in pgAdmin
# DROP SCHEMA public CASCADE;

# ALTER SCHEMA "100pbcd" RENAME TO public;

