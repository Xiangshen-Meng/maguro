description "Ghost at {{ $site->domain }}: Just a blogging platform"

start on (local-filesystems and net-device-up IFACE=eth0)
stop on runlevel [!12345]

# If the process quits unexpectadly trigger a respawn
respawn

setuid ghost
setgid ghost
env NODE_ENV=production
chdir /var/www/{{ $site->domain }}

exec /usr/local/bin/npm start --production

pre-stop exec /usr/local/bin/npm stop --production