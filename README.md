Message Me!
=========

A Symfony project created on February 16, 2019, 5:53 am.


#### How to start

1. Copy `env/.env.app.dist` to `env/.env.app` and do the same for `env/.env.mysql.dist`
2. Run `docker-compose up -d --build --force-recreate`
3. Open [http://localhost:8888](http://localhost:8888)
4. Run `docker-compose logs -f` in order to watch the logs.



#### How this app is working

- This applications consists of two bundles. One of them is the `AppBundle` that
defines two actions, one for rendering a list template and one for the create.

- Each twig template initializes an `vue.js` application that communicate with REST endpoints
defined by the second bundle `MessageBundle`