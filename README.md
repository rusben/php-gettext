# php-gettext

Para instalar y configurar `gettext` en Ubuntu, sigue estos pasos. `gettext` es una herramienta esencial para trabajar con traducciones en proyectos de software, y está disponible en los repositorios oficiales de Ubuntu.

---

### **1. Instalación de gettext**
Abre una terminal y ejecuta el siguiente comando para instalar `gettext`:

```bash
sudo apt update
sudo apt install gettext
```

Este comando instalará las herramientas necesarias para trabajar con archivos `.po`, `.pot` y `.mo`.

---

### **2. Instalación de Poedit (opcional)**
Si prefieres usar una interfaz gráfica para editar archivos `.po`, puedes instalar [Poedit](https://poedit.net/), un editor popular para trabajar con archivos de traducción.

#### **Instalación desde los repositorios de Ubuntu:**

```bash
sudo apt install poedit
```

---

### **3. Uso básico de gettext**
Una vez instalado, puedes comenzar a usar `gettext` para extraer cadenas de traducción de tu código. Aquí hay un ejemplo básico:

#### **Paso 1: Marcar cadenas en tu código PHP**
Usa `_()` o `gettext()` para marcar las cadenas que deben ser traducidas:

```php
<?php
echo _("Hello, world!");
?>
```

#### **Paso 2: Extraer cadenas con xgettext**
Ejecuta el siguiente comando para extraer las cadenas marcadas:

```bash
xgettext --from-code=UTF-8 -o messages.pot *.php
```

Esto generará un archivo `messages.pot` con todas las cadenas encontradas.

#### **Paso 3: Crear archivos `.po` y `.mo`**
Copia el archivo `.pot` para cada idioma y complétalo con las traducciones. Luego, compila el archivo `.po` a `.mo`:

```bash
msgfmt messages.po -o messages.mo
```

---

### **5. Entender cómo funciona gettext**
La función `gettext` (o su alias `_()`) se utiliza para marcar cadenas de texto que deben ser traducidas. Por ejemplo:

```php
echo _("Hello, world!");
```

Aquí, `"Hello, world!"` es el ID que se utilizará para buscar la traducción en los archivos `.po`.

Para generar un archivo `.po`, necesitas extraer todas estas cadenas del código fuente.

---

### **6. Herramientas necesarias**
Para automatizar este proceso, puedes usar las siguientes herramientas:

- **xgettext**: Una herramienta estándar para extraer cadenas de traducción de archivos de código.
- **msgmerge**: Para combinar archivos `.po` existentes con nuevos cambios.
- **msgfmt**: Para compilar archivos `.po` a `.mo` (formato binario utilizado por gettext).

En sistemas basados en Linux, estas herramientas están disponibles en el paquete `gettext`. En Windows, puedes instalarlas a través de MSYS2 o Cygwin.

---

### **7. Pasos para generar archivos `.po`**

#### **Paso 1: Estructura del proyecto**
Asegúrate de que tu proyecto tenga una estructura clara. Por ejemplo:

```
/project
    /locale
        /es_ES
            /LC_MESSAGES
                messages.po
                messages.mo
    index.php
    other_file.php
```

- `/locale`: Carpeta donde se almacenarán los archivos de traducción.
- `/es_ES/LC_MESSAGES`: Carpeta específica para el idioma español (España).
- `messages.po`: Archivo de traducción en formato `.po`.
- `messages.mo`: Archivo compilado en formato `.mo`.

#### **Paso 2: Extraer cadenas con xgettext**
Ejecuta el siguiente comando en la raíz de tu proyecto para extraer todas las cadenas marcadas con `gettext` o `_()`:

```bash
xgettext --from-code=UTF-8 -o locale/messages.pot *.php
```

Explicación:
- `--from-code=UTF-8`: Especifica la codificación del archivo.
- `-o locale/messages.pot`: Genera un archivo `.pot` (Plantilla de traducción) en la carpeta `locale`.
- `*.php`: Busca en todos los archivos PHP en el directorio actual.

Si tienes subdirectorios, usa:

```bash
find . -name "*.php" | xargs xgettext --from-code=UTF-8 -o locale/messages.pot
```

Esto generará un archivo `messages.pot` con todas las cadenas encontradas.

#### **Paso 3: Crear archivos `.po` específicos para cada idioma**
Copia el archivo `.pot` para cada idioma que desees soportar. Por ejemplo, para español (España):

```bash
cp locale/messages.pot locale/es_ES/LC_MESSAGES/messages.po
```

Abre el archivo `messages.po` en un editor de texto o en una herramienta como Poedit, y completa las traducciones. Por ejemplo:

```po
msgid "Hello, world!"
msgstr "¡Hola, mundo!"
```

#### **Paso 4: Compilar el archivo `.po` a `.mo`**
Una vez completadas las traducciones, compila el archivo `.po` a `.mo` usando `msgfmt`:

```bash
msgfmt locale/es_ES/LC_MESSAGES/messages.po -o locale/es_ES/LC_MESSAGES/messages.mo
```

El archivo `.mo` es el que PHP utilizará para cargar las traducciones.

---

### **8. Configurar PHP para usar gettext**
En tu código PHP, configura gettext para usar las traducciones:

```php
<?php
// Configuración de gettext
$locale = "es_ES"; // Idioma deseado
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);

// Ruta a la carpeta de traducciones
bindtextdomain("messages", "./locale");
textdomain("messages");

// Ejemplo de uso
echo _("Hello, world!"); // Salida: ¡Hola, mundo!
?>
```

---

### **9. Automatización con scripts**
Puedes crear un script para automatizar todo el proceso. Por ejemplo, un script Bash:

```bash
#!/bin/bash

# Extraer cadenas de traducción
find . -name "*.php" | xargs xgettext --from-code=UTF-8 -o locale/messages.pot

# Crear o actualizar archivos .po para cada idioma
for lang in es_ES fr_FR; do
    mkdir -p "locale/$lang/LC_MESSAGES"
    if [ ! -f "locale/$lang/LC_MESSAGES/messages.po" ]; then
        cp locale/messages.pot "locale/$lang/LC_MESSAGES/messages.po"
    else
        msgmerge -U "locale/$lang/LC_MESSAGES/messages.po" locale/messages.pot
    fi
done

# Compilar archivos .po a .mo
for lang in es_ES fr_FR; do
    msgfmt "locale/$lang/LC_MESSAGES/messages.po" -o "locale/$lang/LC_MESSAGES/messages.mo"
done
```

Guarda este script como `update_translations.sh`, hazlo ejecutable (`chmod +x update_translations.sh`) y ejecútalo cada vez que necesites actualizar las traducciones.

---

### **10. Consideraciones adicionales**
- Asegúrate de que las cadenas en tu código sean consistentes. Evita duplicar cadenas con pequeñas variaciones.
- Si usas otros frameworks o bibliotecas, verifica si tienen soporte integrado para gettext o si necesitan configuraciones adicionales.

---

### **Conclusión**
Siguiendo estos pasos, puedes automatizar la extracción de IDs de traducción de tu código PHP y generar archivos `.po` para gestionar tus traducciones de manera eficiente. Usa herramientas como `xgettext`, `msgmerge` y `msgfmt` para simplificar el proceso, y considera escribir scripts para automatizar tareas repetitivas.
