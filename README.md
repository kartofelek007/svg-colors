# Zamienia kolory w svg

## Użycie
Można używać do 100 par gdzie **cX** oznacza szukany kolor, a **toX** oznacza na jaki kolor zostanie zamienione. Pierwsza para jest bez numeru, czyli **c** i **to**.

Kolory można podawać hexadecymalnie (bez #) i za pomocą nazwy koloru w css.

```
<img src="images/file.svg?c=red&to=blue">
<img src="images/other.svg?c=red&to=fff&c2=blue&to2=orange">
<img src="images/other.svg?c=red&to=fff&c2=blue&to2=orange&c3=violet&to3=333">
```