DROP TABLE IF EXISTS "esgi_user";
DROP TABLE IF EXISTS "esgi_token";
DROP TABLE IF EXISTS "esgi_comments";
DROP TABLE IF EXISTS "esgi_posts";
DROP TABLE IF EXISTS "esgi_categories";
DROP TABLE IF EXISTS "esgi_menus";

CREATE TABLE "public"."esgi_user" (
    "id" SERIAL PRIMARY KEY,
    "firstname" character(255) NOT NULL,
    "lastname" character(255) NOT NULL,
    "email" character(255) UNIQUE NOT NULL,
    "password" character(255) NOT NULL,
    "status" boolean DEFAULT false NOT NULL,
    "date_inserted" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "role" VARCHAR(20) NOT NULL DEFAULT 'guest'
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

-- Categories Table
CREATE TABLE "public"."esgi_categories" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(255) UNIQUE NOT NULL,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) WITH (oids = false);

-- Posts Table
CREATE TABLE "public"."esgi_posts" (
    "id" SERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL,
    "content" TEXT NOT NULL,
    "user_id" INTEGER REFERENCES esgi_user(id),
    "category_id" INTEGER REFERENCES esgi_categories(id),
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) WITH (oids = false);

-- Comments Table
CREATE TABLE "public"."esgi_comments" (
    "id" SERIAL PRIMARY KEY,
    "content" TEXT NOT NULL,
    "user_id" INTEGER REFERENCES esgi_user(id),
    "post_id" INTEGER REFERENCES esgi_posts(id),
    "is_published" BOOLEAN DEFAULT false,
    "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) WITH (oids = false);

CREATE TABLE "public"."esgi_menus" (
    "id" SERIAL PRIMARY KEY,
    "name" VARCHAR(255) NOT NULL,
    "url" VARCHAR(255) NOT NULL,
    "order" INT
) WITH (oids = false);