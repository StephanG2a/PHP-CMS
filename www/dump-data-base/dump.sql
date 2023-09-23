DROP TABLE IF EXISTS "esgi_user";
DROP TABLE IF EXISTS "esgi_token";

CREATE TABLE "public"."esgi_user" (
    "id" SERIAL PRIMARY KEY,
    "firstname" character(255) NOT NULL,
    "lastname" character(255) NOT NULL,
    "email" character(255) UNIQUE NOT NULL,
    "password" character(255) NOT NULL,
    "status" boolean DEFAULT false NOT NULL,
    "date_inserted" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL
) WITH (oids = false);

CREATE TABLE "public"."esgi_token" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INTEGER REFERENCES esgi_user(id), 
    "token" VARCHAR(255) UNIQUE NOT NULL,
    "expires_at" TIMESTAMP NOT NULL,
    "type" VARCHAR(50) NOT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) WITH (oids = false);
