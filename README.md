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
6. int id = add_vote([User, ]Purchase_id); // Добавляет голос, возвращает идентификатор голоса
7. MealCard m = add_mealcard([User, ]fridge_id, MealCard);   // Добавить продукт в холодильник

### Remove

1. rm_fridge([User, ]Fridge); // также удаляет всех пользователей- rm_fridgeuser()
2. Payments = rm_fridgeuser([User, ]Fridge, FridgeUser);  // удаляет пользователя холодильника, вызывает calc() и выравнивает баланс проводками "Долг" add_purchase()
3. rm_purchase([User, ]Purchase);   // сторнирование
4. rm_vote([User, ]Purchase_id); // Отзывает голос

### List

1. UserFridges uf = ls_userfridge([User, ])	// список холодильников с едой
2. Fridges f = ls_fridge([User, ]Fridge); // список холодильников пользователя
3. FridgeUsers fu = ls_fridgeuser([User, ]Fridge, FridgeUser);  // список пользователей холодильника
4. Purchases p = ls_purchase([User, ]Purchase); // список покупок пользователя
5. Meals m = ls_meal([User]); // список продуктов
6. MealCards c = ls_mealcard([User, ]Fridge); // список продуктов в холодильнике

### Helper functions

#### Расчет баланса

Баланс считается для одного или всех пользователей холодильника

1. $balance_array = calc_pg_user($conn, $fridge_id, $user_id);
2. $balance_array = calc_pg_fridge($conn, $fridge_id);

## Command line interface tool

### Тестовый сервер

Опция -u

```
-u "http://localhost:8080/" 
```
### Добавить

Пользователя, параметры:

- n имя
- l, o, a координаты

```
buy-n-share --add user -e ru -n "Alice" -l 62.028098 -o 129.732555 -a 100
```

Холодильник, параметры:

- i идентификатор пользователя
- n название
- l, o, a координаты

```
buy-n-share --add fridge -e ru -n "Fridge 1" -l 62.028098 -o 129.732555 -a 100
```

Пользователя холодильника, параметры:

- i идентификатор пользователя
- f идентификатор холодильника
- c баланс

```
buy-n-share --add fridgeuser --add fridgeuser -i 2 -f 2 -c 45
```

Продукт в холодильник, параметры:

- m идентификатор продукта
- f идентификатор холодильника
- q количество

```
buy-n-share --add mealcard -m 2 -f 2 -q 3
```

Купить продукт для холодильника, параметры:

- i идентификатор пользователя
- m идентификатор продукта
- f идентификатор холодильника
- q добавляемое количество
- c стоимость

```
buy-n-share --add purchase -i 2 -m 2 -f 2 -q 3 -c 100
```

Добавить голос покупке продукта для холодильника, параметры:

- i идентификатор пользователя
- p идентификатор покупки

```
buy-n-share --add vote -i 3 -p 10
```

### Списки

Холодильники

- e локаль
- l, o, a координаты

```
buy-n-share --ls fridge -e ru -l 62.028098 -o 129.732555 -a 100
```

Пользователи холодильника

- f идентификатор холодильника

```
buy-n-share --ls fridgeuser -f 2
```

Наименования продуктов

- e локаль

```
buy-n-share --ls meal -e ru
```

Продукты в холодильнике

- f идентификатор холодильника
```
buy-n-share --ls mealcard -f 2
```

Покупки пользователя 

- i идентификатор пользователя
- f идентификатор холодильника

Во все холодильники:

```
buy-n-share --ls purchase -i 2
```

В один холодильник:

```
buy-n-share --ls purchase -i 2 -f 2
```

Пользователи:

```
buy-n-share --ls user
```

### Удаление

Пользователя

- i Идентификатор пользователя

```
buy-n-share --rm user -i 2
```

Холодильника

- f Идентификатор холодильника

```
buy-n-share --rm fridge -f 2
```

Пользователя холодильника

- f Идентификатор холодильника
- i Идентификатор пользователя

```
buy-n-share --rm fridgeuser -f 2 -i 2
```

Голоса

- p Идентификатор покупки
- i Идентификатор пользователя

```
buy-n-share --rm vote -p 2 -i 2
```

Пользователя холодильника

- i Идентификатор пользователя
- f Идентификатор холодильника

```
buy-n-share --rm fridgeuser -i 3 -f 2
```

ls_userfridge


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

### Включение gzip

env.php:
```
ob_start("ob_gzhandler");
```