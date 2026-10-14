<div align="center">

# php-urt

![php-urt: ask a game server who is playing](https://raw.githubusercontent.com/nadimtuhin/php-urt/master/docs/images/hero.svg)

**Who is on the server?** Ask it over UDP, in a few lines of PHP.

`MIT` `PHP` `Urban Terror`

</div>

<br>

A small PHP project that asks an Urban Terror (URT) game server for its status. It shows the map name and the players, sorted by ping, highest first. One page for people, one JSON endpoint for scripts.

<br>

![Get started](https://raw.githubusercontent.com/nadimtuhin/php-urt/master/docs/images/h-start.svg)

You need PHP with the sockets extension, and [Composer](https://getcomposer.org).

**1. Get the code and install it:**

```bash
git clone https://github.com/nadimtuhin/php-urt.git && cd php-urt
composer install
```

**2. Make your config file:**

```bash
cp .env.example .env
```

Open `.env` and set `host`, `port` and `connection_timeout` (seconds). The example file points at a sample server, so put your own in.

If the server doesn't answer, the page shows `Fatal error: ... Unable to connect to server`. Check `host` and `port`.

**3. Run it:**

```bash
php -d error_reporting='E_ALL & ~E_DEPRECATED' -S localhost:8000 -t public
```

Open `http://localhost:8000/` for the player table, or `http://localhost:8000/api.php` for JSON. The page refreshes itself every 60 seconds.

<br>

![How it works](https://raw.githubusercontent.com/nadimtuhin/php-urt/master/docs/images/h-how.svg)

**It sends one UDP packet.** The packet is the `getstatus` query that Quake 3 style servers answer. The server replies with its settings and one line per player.

**Then it tidies the answer.** `getUrtServerStatus()` returns `players` (name, score, ping) and `info` (map name, max clients and the other server settings).

<br>

![For developers](https://raw.githubusercontent.com/nadimtuhin/php-urt/master/docs/images/h-dev.svg)

Everything below is the original reference. You don't need it to get started.

## Setup

Rename `.env.example` to `.env`.

## Configuration

```
host: urt server IP

port: urt server port

connection_timeout: seconds
```
