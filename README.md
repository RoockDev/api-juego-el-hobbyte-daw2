# api-juego-el-hobbyte-daw2
# El Hobbit: El Juego de Pruebas

> **Desafío 1 - 2º CFGS DAW - Desarrollo WEB en entorno servidor**
>
> *CIFP Virgen de Gracia*

---

## 📄 Enunciado del Desafío

### 🎮 El Juego

Pues sí, sí, es un chiste: ¿qué son 8 hobbits? Pues eso. Aunque igual al final es un chiste al que, me temo, no le veréis la gracia... Ya veremos.

El juego consiste en lo siguiente:

- Tenemos **tres personajes**: **Gandalf**, **Thorin** y **Bilbo**.
  - **Gandalf** puede hacer las pruebas de **magia**.
  - **Thorin** las de **fuerza**.
  - **Bilbo** las de **habilidad**.
  - Los tres parten con una **capacidad máxima respectiva de 50**.
- Se genera un **tablero de 20 casillas** en las que habrá **escondidas 20 pruebas** (una por casilla).
  - Las pruebas pueden ser de los **3 tipos** (magia, fuerza o habilidad).
  - La **cantidad de esfuerzo** necesario para lograrla serán los siguientes números posibles: **5, 10, 15, 20, 25, 30, 35, 40, 45 y 50**.
  - La **probabilidad** de rellenar el tablero con cada uno de ellos es la siguiente:
    - **5 a 20**: al **65%**.
    - **25 a 40**: al **30%**.
    - **45 a 50**: al **5%**.
- Una vez generado el tablero (los tableros), comienza el juego. Consiste en **destapar casillas** y **realizar las pruebas** (por el héroe correspondiente y si le queda poder) de forma que:
  - Si el **poder del héroe es mayor** que el necesario para realizar la prueba se logra la prueba al **90%**.
  - Si es **igual** se logra al **70%**.
  - Si es **menor** se consigue al **50%**.
  - Si **no se logra**, ese héroe **pierde toda su capacidad** y quedará **inactivo**.
  - Si **se logra** **pierde la capacidad necesaria** para lograr la prueba (se resta).
  - Si al héroe **no le quedara poder** para afrontar la prueba se debe dar por **perdida**.
- **Ganamos** cuando hemos logrado **destapar la mitad de las casillas** y **vive, al menos, un héroe**.
- **Perdemos** si **nos quedamos sin héroes** o si hemos **destapado 5 casillas seguidas perdiendo**.

---

## 👥 Roles de Usuario

### Administradores

- Los administradores podrán **gestionar a los usuarios**: altas, bajas, modificaciones, cambios de rol, etc.
- Un administrador también podrá ser **jugador**.

### Jugadores

- Los jugadores podrán tener como **máximo dos partidas abiertas**.
- Siempre se jugará **contra la máquina**.
- Para simplificar, el **mapa será lineal** (un array sería correcto) pero se deja abierto como **opcional un mapa más elaborado** que permita otra distribución de los territorios.

---

## 🔌 Servicios y Rutas

### Servicio Administrador

- El administrador tendrá una **ruta especial `/admin`**, a través de la cual podrá hacer lo **básico necesario para un CRUD de usuarios**.
- También podrá **cambiar el rol del usuario** (administrador, jugador).
- Los **verbos y códigos** serán los **habituales** (GET, POST, PUT, DELETE, 200, 201, 400, 404, 500, etc.).

### Servicio Jugador

- Todos los usuarios podrán entrar al sistema a **cambiar su contraseña**, **restaurarla**, **consultar sus datos** y sus **estadísticas**; la ruta será `/user`.
- Y, claro, podrá acceder como **jugador** con la ruta `/gamer`.
- Mediante esta ruta el jugador podrá:
  - **Crear una partida estándar** (20 casillas, 20 pruebas) o **crear una partida personalizada** en cuanto a casillas y pruebas, con el correspondiente **control de errores**.
  - **Destapar una casilla**: se destapará una prueba y la realizará el héroe correspondiente; se informará al cliente de todo lo que pase: **casilla destapada**, **estado actual del mapa**, **estado de los héroes** y **estado de la partida** (ganada, perdida, en curso).
    - Tendremos el **control de errores** de que la partida exista y esté en curso, además de los controles de errores de la casilla.
  - **Posibilidad de rendirse**: Se mostrará el mapa tal y como estaba predefinido y como han quedado los héroes.
  - El servicio informará al usuario del **final de la partida** y del **resultado de esta**, cuando sea el caso.
  - **Cualquier otra ruta y servicio** que esté **justificado** y creas **conveniente**.

---

## ℹ️ Importante

Recuerda que estás haciendo el **servicio**, las rutas que llamarás para crear el juego en el cliente. En el cliente interactúas con el usuario para:

- Elegir tablero (si tienes más de una partida en curso).
- Le mostrarías el estado de la partida.
- Le pedirías qué casilla levantar.
- Informarías de lo que ha pasado tras la última acción.
- Etc.

Estas cosas que necesitarías hacer en el cliente deben tener su **ruta en el servidor** donde estará la **base de datos** y la **lógica del juego**.
Puedes crear alguna **ruta más** si lo crees conveniente y está justificada.

---

## 🧭 Anexo: Metodología SCRUM

SCRUM es una metodología ágil en la que se aplican regularmente un conjunto de buenas prácticas para trabajar en equipo y obtener el mejor resultado en el proyecto.

En SCRUM se realizan entregas parciales y regulares del producto final, priorizándolas según el beneficio que aportan al receptor del proyecto (cliente).

### Roles

- **Product Owner**: Se encarga de analizar qué es lo que quiere el cliente final en su proyecto y lo detalla en una lista priorizada (product backlog).
- **Scrum Master**: Organiza y facilita el trabajo. Defiende la metodología a llevar a cabo ante el product owner.
- **Team**: Equipo de desarrolladores. Analizan las tareas del product backlog, detallan los ítems que van a contener, su prioridad y el tiempo que les va a llevar realizarlas.

Una persona puede tener más de un rol. Por ejemplo, el scrum master puede formar parte del equipo de desarrollo.

### Funcionamiento

- El trabajo se organiza en **sprints**. Un sprint tiene un tiempo acotado (por ejemplo 2 semanas) y en él se incluyen las tareas (historias) establecidas en el product backlog.
- El sprint comienza con una **planificación (planning)**: se reúne el team, product owner y scrum master. Se analiza cada tarea establecida por el product owner en el backlog. Se prioriza, determina la dificultad técnica por el equipo de desarrollo y se establece el tiempo que tardará en completarse. Una vez analizada, se decide si esa tarea “cabe” en dicho sprint, en cuyo caso, el team se **COMPROMETE** a realizarla en dicho sprint.
- Cuando finaliza el sprint, se realiza una **retrospectiva** analizando lo que se ha hecho bien y lo que se ha hecho mal, para proponer mejoras al respecto. Después se realiza una **demo** de las historias del sprint que se han completado, ante el product owner (y a veces ante el cliente final).
- Cada día del sprint se hará una pequeña reunión denominada **daily** (tiene que ser corta (10’) y se obliga a estar de pie para que no se alargue), en la que cada miembro del equipo de desarrollo cuenta en lo que ha trabajado, las dificultades y si necesita ayuda por parte del resto del equipo.
- Cuando comienza un sprint, existe un **tablero** donde se encuentran todas las tareas sin asignar pendientes del sprint (backlog), y que cada desarrollador irá escogiendo (teniendo en cuenta al equipo) y asignando según sus preferencias, ritmo de trabajo, etc.

---

## 📝 Descripción Breve de lo Necesario

Este proyecto requiere el desarrollo de un **servicio web en PHP** que implemente la lógica del juego descrito. El cliente interactuará con este servicio a través de **rutas RESTful** para gestionar usuarios, partidas, y realizar las acciones del juego (destapar casillas, crear partidas, etc.). Es fundamental un **diseño de base de datos** robusto, una **arquitectura de código limpia** y **patrones de diseño** adecuados. Se debe gestionar el proyecto con **Git** y una **herramienta de planificación** (como un tablero Kanban) siguiendo la metodología **SCRUM**.
