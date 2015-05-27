server {
    listen 80;
    listen [::]:80;

    server_name {{ $site->domain }};

    root /usr/share/nginx/html;
    index index.html index.htm;

    client_max_body_size 10G;

    location / {
    proxy_pass http://localhost:{{ $site->port }};
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header Host $http_host;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_buffering off;
    }
}