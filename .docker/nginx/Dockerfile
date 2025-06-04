FROM almalinux:9

COPY nginx.repo /etc/yum.repos.d/nginx.repo

RUN dnf update -y \
    && dnf install -y epel-release \
    && dnf install -y --disablerepo=appstream nginx \
    && dnf clean all

RUN mkdir -p /var/log/nginx \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

WORKDIR "/usr/share/nginx/html"

EXPOSE 80/tcp

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
