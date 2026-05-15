FROM postgres:15-alpine

ENV POSTGRES_PASSWORD docker
ENV POSTGRES_DB db
ENV POSTGRES_USER docker

# Dodaj to, aby wymusić nową inicjalizację
RUN rm -rf /var/lib/postgresql/data/*