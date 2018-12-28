kdm44
========

kdm44.ru

## Требования к программному обеспечению

| Приложения | Версии | Где взять |
| --- | --- | --- |
|docker |
|docker-compose
| Git | ^2.16 | https://git-scm.com/ |

## Установка на ubuntu 18.04
- sudo apt-get remove -y docker docker-engine docker.io
- sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common
- curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
- sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
- sudo apt-get update
- sudo apt-get install docker-ce
- sudo usermod -aG docker ИмяВашегоПользователя
- sudo systemctl restart docker
- Перелогиниваемся под ИмяВашегоПользователя или reboot
- ``` sudo curl -L https://github.com/docker/compose/releases/download/1.23.2/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose && sudo chmod +x /usr/local/bin/docker-compose ```

## Установка на MacOS
- https://docs.docker.com/docker-for-mac/install/#install-and-run-docker-for-mac

## Установка на Windows
- https://docs.docker.com/docker-for-windows/install/#install-docker-for-windows-desktop-app

## Настройки локального окружения для U'CANN

- Вы склонировали репозиторий
## Запуск
- Если вам нужен только этот проект то переименуйте docker-compose-only.yml в docker-compose.yml и `docker-compose up` или `docker-compose up -d` для работы в фоне
- Если вы испольуете множество контейнеров с разными проектами то
  - Запустите proxy из реп `ssh://git@git.ucann.ru/devops/proxy.git` (описние в readme.md)
  - Переименуйте docker-compose-proxy.yml в docker-compose.yml и `docker-compose up` или `docker-compose up -d` для работы в фоне
- Собираем проект
  - `docker-compose exec kdm44_php phing -f build/dev/build.xml`
- Заходите на https://dev.kdm44.ucann.ru/

## Выключение и удаление
- ``` `docker-compose down`  или `docker-compose down -v` для удаления базы ```


## База данных
- Подключение к БД geo из шторма:
- ```jdbc:mysql://127.0.0.1:3306/kdm44?user=kdm44&password=kdm44```