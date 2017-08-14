# buy-n-share

Мобильное приложение для управления совместными финансами с долевым участием при покупке еды.

- [Repository git@github.com:commandus/buy-n-share.git](https://github.com/commandus//buy-n-share.git)
- [Site https://github.com/commandus//buy-n-share](https://github.com/commandus//buy-n-share)

[Диаграмма классов](https://repository.genmymodel.com/commandus/fridge):

![Диаграмма классов](http://f.commandus.com/i/d/diagram-gmm.png#1)

Сериализация - описание в файле [flatbuffers](https://github.com/commandus/buy-n-share/blob/master/fbs/buynshare.fbs)

## Аудитория 

Покупка еды для офиса.

## Назначение

1. к празднику
2. будни
3. легкий каприз(вдруг чего то вкусненького захотелось)

### Учет запасов

Начальный экран показывает виртуальное содержимое офисного холодильника в условных единицах:

1. Идентификатор "холодильника" (клик -> учет его пользователей)
2. Список
  - перцы полоска прогресса 1/16 (1- очень мало, 16- очень много)
  - курица 8/16 (норм)
  - морковь 0/16 (надо купить)
  - яблоки 2/16
  - [+] 0/16 добавляет новый продукт
3. Фото продукта служит напоминанием Пользователям, что нужно купить
4. рецепт
5. цена и где куплено(чтоб мониторить где можно купить потдешевле)
6. Функция угадывания продукта по начальным буквам(например ,,ба''и высвечивает бананы)	
7. На индикатор на иконке приложения загорается цифра с кол-м некупленных продуктов.

Клик на элемент списка -> Учет покупки

#### Учет расхода

Свайп влево, вправо- увеличение или уменьшение количества продукта.

### Учет покупки

- Ввод стоимости

"Чек" - наименование продукта, Пользователь сделавший покупку, Дата покупки (для прогресса порчи продукта)

Кнопка Ввод- возвррат к учету запасов

### Учет Пользвателей

1. Идентификатор "холодильника" (клик -> Учет Холодильников, к которым привязан Пользователь)
2. Список Пользователей, привязанных к Холодильнику

Элемент списка:

- ник Пользователя
- сумма покупок
- сумма возвратов
- баланс - красный: мало покупок, зеленый- слишком много покупок, белый или черный- отклонение не более xxx%

### Приглашение в холодильник

Ввод 

- номера Холодильника
- стартовая сумма взноса (по умолчанию 0)

## CLI клиент

Linux клиент команднй строки

###  Зависимости

Перед сборкой необходимо установить библиотеки:

- [argtable2](http://argtable.sourceforge.net/doc/argtable2.html)
- [curl](https://curl.haxx.se)
- [flatbuffers](https://github.com/google/flatbuffers)

и компилятор [flatc](https://google.github.io/flatbuffers/flatbuffers_guide_building.html), который собирается [cmake](https://cmake.org/)

###  Сборка

```
./autogen.sh
./configure
./make
```

### База данных

Заходим пользователем postgres

```
sudo su - postgres
```

Создаем пользователя, вводим пвроль:
```
createuser commandus_buynshare1 -W
Password: 
```

Создаем базу данных с новым владельцем:
```
psql
CREATE DATABASE commandus_buynshare WITH OWNER = commandus_buynshare1 ENCODING = 'UTF8';
# Если надо, даем права кому нибудь еще
# GRANT commandu_buynshare TO somebody;
grant all on schema public to commandu_buynshare1;
grant all on schema public to commandu_buynshare2;
\q
```

Выходим из сессии postgres
```
exit
```
## API

### Add

1. User u = add_user(User); // регистрация
2. Fridge f = add_fridge([User, ]Fridge); // также добавляет создателя в пользователи холодильника- add_fridgeuser()
3. FridgeUser fu = add_fridgeuser([User, ]Fridge, FridgeUser[, Взнос]);  // добавляет пользователя в холодильник
4. Meal m = add_meal([User, ]Meal);   // Новый продукт
5. Purchase p = add_purchase([User, ]Purchase); // Добавляет также голос. Используется для проводок "Долг"
6. Vote v = add_vote([User, ]Purchase); // Добавляет голос

### Remove

1. rm_fridge([User, ]Fridge); // также удаляет всех пользователей- rm_fridgeuser()
2. Balance = rm_fridgeuser([User, ]Fridge, FridgeUser);  // удаляет пользователя холодильника, вызывает calc() и выравнивает баланс проводками "Долг" add_purchase()
3. rm_purchase([User, ]Purchase);   // сторнирование
4. rm_vote([User, ]Purchase); // Отзывает голос

### List

1. ls_fridge([User, ]Fridge); // список холодильников пользователя
2. ls_fridgeuser([User, ]Fridge, FridgeUser);  // список пользователей холодильника
3. ls_purchase([User, ]Purchase); // список покупок пользователя
4. ls_meal([User]); // список продуктов
5. ls_mealcard([User, ]Fridge); // список продуктов в холодильнике

### Calc
1. Balance = calc([User, ]Fridge)

## Building Windows using Visual Studio 2017

- cmake 
- argtable2
- flatbuffers 
- curl

### flatbuffers 

```
git clone git@github.com:google/flatbuffers.git
cmake -G "Visual Studio 15"

```

### Curl 

Установка пакета как:
```
Install-Package curl
```
неверная, так как пакет собран неправильно. Надо библиотеку собрать вручную.
